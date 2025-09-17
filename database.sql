-- إنشاء قاعدة البيانات

-- جدول المستخدمين
CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    role ENUM('admin', 'writer', 'editor') NOT NULL DEFAULT 'editor',
    status ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- جدول الأنظمة
CREATE TABLE IF NOT EXISTS systems (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    created_by INT(11) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- جدول المواد
CREATE TABLE IF NOT EXISTS laws (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    system_id INT(11) NOT NULL,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (system_id) REFERENCES systems(id) ON DELETE CASCADE
);

-- جدول الأجزاء
CREATE TABLE IF NOT EXISTS articles (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    law_id INT(11) NOT NULL,
    number INT(11) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (law_id) REFERENCES laws(id) ON DELETE CASCADE
);

-- جدول تصنيفات المدونات
CREATE TABLE IF NOT EXISTS categories (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- جدول المدونات
CREATE TABLE IF NOT EXISTS blogs (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    category_id INT(11) NOT NULL,
    author_id INT(11) NOT NULL,
    status ENUM('draft', 'published') NOT NULL DEFAULT 'draft',
    tags VARCHAR(255),
    system_reference INT(11),
    law_reference INT(11),
    article_reference INT(11),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    published_at TIMESTAMP NULL,
    FOREIGN KEY (category_id) REFERENCES categories(id),
    FOREIGN KEY (author_id) REFERENCES users(id),
    FOREIGN KEY (system_reference) REFERENCES systems(id),
    FOREIGN KEY (law_reference) REFERENCES laws(id),
    FOREIGN KEY (article_reference) REFERENCES articles(id)
);

-- جدول وسائط المدونات
CREATE TABLE IF NOT EXISTS blog_media (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    blog_id INT(11) NOT NULL,
    media_type ENUM('image', 'video', 'link') NOT NULL,
    media_url VARCHAR(255) NOT NULL,
    media_text VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (blog_id) REFERENCES blogs(id) ON DELETE CASCADE
);

-- جدول الأدوار والصلاحيات
CREATE TABLE IF NOT EXISTS roles (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- جدول الصلاحيات
CREATE TABLE IF NOT EXISTS permissions (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- جدول صلاحيات الأدوار
CREATE TABLE IF NOT EXISTS role_permissions (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    role_id INT(11) NOT NULL,
    permission_id INT(11) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE,
    FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE,
    UNIQUE KEY unique_role_permission (role_id, permission_id)
);

-- جدول سجل النشاطات
CREATE TABLE IF NOT EXISTS activity_log (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    action VARCHAR(50) NOT NULL,
    description TEXT,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- إدخال بيانات أولية

-- إدخال المستخدم الافتراضي (مدير)
INSERT INTO users (username, email, password, full_name, role) VALUES 
('admin', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'مدير النظام', 'admin');

-- إدخال تصنيفات المدونات
INSERT INTO categories (name, description) VALUES 
('قانوني', 'مدونات تتعلق بالقوانين والأنظمة'),
('اجتماعي', 'مدونات تتعلق بالقضايا الاجتماعية'),
('اقتصادي', 'مدونات تتعلق بالقضايا الاقتصادية'),
('ثقافي', 'مدونات تتعلق بالقضايا الثقافية');

-- إدخال الأدوار
INSERT INTO roles (name, description) VALUES 
('مدير', 'صلاحيات كاملة على النظام'),
('كاتب', 'يمكنه إنشاء وتعديل ونشر المدونات'),
('محرر', 'يمكنه عرض وتعديل المدونات المعينة له فقط');

-- إدخال الصلاحيات
INSERT INTO permissions (name, description) VALUES 
('view_systems', 'عرض الأنظمة والقوانين'),
('add_systems', 'إضافة أنظمة وقوانين'),
('edit_systems', 'تعديل الأنظمة والقوانين'),
('delete_systems', 'حذف الأنظمة والقوانين'),
('view_blogs', 'عرض المدونات'),
('add_blogs', 'إضافة مدونات'),
('edit_blogs', 'تعديل المدونات'),
('delete_blogs', 'حذف المدونات'),
('publish_blogs', 'نشر المدونات'),
('manage_users', 'إدارة المستخدمين'),
('manage_roles', 'إدارة الأدوار والصلاحيات');

-- إدخال صلاحيات الأدوار
-- صلاحيات المدير
INSERT INTO role_permissions (role_id, permission_id) 
SELECT 1, id FROM permissions WHERE name IN 
('view_systems', 'add_systems', 'edit_systems', 'delete_systems', 
'view_blogs', 'add_blogs', 'edit_blogs', 'delete_blogs', 'publish_blogs',
'manage_users', 'manage_roles');

-- صلاحيات الكاتب
INSERT INTO role_permissions (role_id, permission_id) 
SELECT 2, id FROM permissions WHERE name IN 
('view_systems', 'view_blogs', 'add_blogs', 'edit_blogs', 'publish_blogs');

-- صلاحيات المحرر
INSERT INTO role_permissions (role_id, permission_id) 
SELECT 3, id FROM permissions WHERE name IN 
('view_systems', 'view_blogs', 'edit_blogs');
