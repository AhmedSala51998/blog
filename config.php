<?php
// إعدادات الاتصال بقاعدة البيانات
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'blog_dashboard');

// محاولة الاتصال بقاعدة البيانات
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// التحقق من الاتصال
if($conn === false){
    die("خطأ: لا يمكن الاتصال بقاعدة البيانات. " . mysqli_connect_error());
}

// تعيين ترميز الاتصال ليدعم العربية
mysqli_set_charset($conn, "utf8mb4");
?>
