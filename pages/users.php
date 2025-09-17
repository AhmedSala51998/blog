<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">المستخدمين والصلاحيات</h4>
                    <button id="addUserBtn" class="btn btn-primary">
                        <i class="fas fa-plus"></i> إضافة مستخدم جديد
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>المستخدم</th>
                                    <th>البريد الإلكتروني</th>
                                    <th>الدور</th>
                                    <th>تاريخ التسجيل</th>
                                    <th>الحالة</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar">أحمد</div>
                                            <div class="user-info">
                                                <p class="user-name">أحمد محمد</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>ahmed@example.com</td>
                                    <td><span class="badge bg-primary">مدير</span></td>
                                    <td>2023-01-15</td>
                                    <td><span class="badge bg-success">نشط</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-info edit-user-btn"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-danger delete-user-btn"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar">محمد</div>
                                            <div class="user-info">
                                                <p class="user-name">محمد علي</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>mohammed@example.com</td>
                                    <td><span class="badge bg-info">كاتب</span></td>
                                    <td>2023-02-20</td>
                                    <td><span class="badge bg-success">نشط</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-info edit-user-btn"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-danger delete-user-btn"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar">فاطمة</div>
                                            <div class="user-info">
                                                <p class="user-name">فاطمة أحمد</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>fatima@example.com</td>
                                    <td><span class="badge bg-secondary">محرر</span></td>
                                    <td>2023-03-10</td>
                                    <td><span class="badge bg-warning">غير نشط</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-info edit-user-btn"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-danger delete-user-btn"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">الأدوار والصلاحيات</h4>
                </div>
                <div class="card-body">
                    <div class="role-item mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5>مدير</h5>
                            <div>
                                <button class="btn btn-sm btn-info edit-role-btn"><i class="fas fa-edit"></i></button>
                            </div>
                        </div>
                        <p>صلاحيات كاملة على النظام</p>
                        <div class="permissions">
                            <span class="badge bg-success me-1">عرض الأنظمة</span>
                            <span class="badge bg-success me-1">إضافة أنظمة</span>
                            <span class="badge bg-success me-1">تعديل الأنظمة</span>
                            <span class="badge bg-success me-1">حذف الأنظمة</span>
                            <span class="badge bg-success me-1">عرض المدونات</span>
                            <span class="badge bg-success me-1">إضافة مدونات</span>
                            <span class="badge bg-success me-1">تعديل المدونات</span>
                            <span class="badge bg-success me-1">حذف المدونات</span>
                            <span class="badge bg-success me-1">إدارة المستخدمين</span>
                        </div>
                    </div>

                    <div class="role-item mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5>كاتب</h5>
                            <div>
                                <button class="btn btn-sm btn-info edit-role-btn"><i class="fas fa-edit"></i></button>
                            </div>
                        </div>
                        <p>يمكنه إنشاء وتعديل ونشر المدونات</p>
                        <div class="permissions">
                            <span class="badge bg-success me-1">عرض الأنظمة</span>
                            <span class="badge bg-light text-dark me-1">إضافة أنظمة</span>
                            <span class="badge bg-light text-dark me-1">تعديل الأنظمة</span>
                            <span class="badge bg-light text-dark me-1">حذف الأنظمة</span>
                            <span class="badge bg-success me-1">عرض المدونات</span>
                            <span class="badge bg-success me-1">إضافة مدونات</span>
                            <span class="badge bg-success me-1">تعديل المدونات</span>
                            <span class="badge bg-success me-1">حذف المدونات</span>
                            <span class="badge bg-light text-dark me-1">إدارة المستخدمين</span>
                        </div>
                    </div>

                    <div class="role-item">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5>محرر</h5>
                            <div>
                                <button class="btn btn-sm btn-info edit-role-btn"><i class="fas fa-edit"></i></button>
                            </div>
                        </div>
                        <p>يمكنه عرض وتعديل المدونات المعينة له فقط</p>
                        <div class="permissions">
                            <span class="badge bg-success me-1">عرض الأنظمة</span>
                            <span class="badge bg-light text-dark me-1">إضافة أنظمة</span>
                            <span class="badge bg-light text-dark me-1">تعديل الأنظمة</span>
                            <span class="badge bg-light text-dark me-1">حذف الأنظمة</span>
                            <span class="badge bg-success me-1">عرض المدونات</span>
                            <span class="badge bg-light text-dark me-1">إضافة مدونات</span>
                            <span class="badge bg-success me-1">تعديل المدونات</span>
                            <span class="badge bg-light text-dark me-1">حذف المدونات</span>
                            <span class="badge bg-light text-dark me-1">إدارة المستخدمين</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">سجل النشاطات</h4>
                </div>
                <div class="card-body">
                    <ul class="timeline">
                        <li class="timeline-item">
                            <div class="timeline-badge"><i class="fas fa-user-plus text-primary"></i></div>
                            <div class="timeline-card">
                                <div class="timeline-head">
                                    <span>إضافة مستخدم جديد</span>
                                    <small class="text-muted">منذ 10 دقائق</small>
                                </div>
                                <div class="timeline-body">
                                    قام <strong>أحمد محمد</strong> بإضافة مستخدم جديد: <strong>خالد سالم</strong>
                                </div>
                            </div>
                        </li>
                        <li class="timeline-item">
                            <div class="timeline-badge"><i class="fas fa-file-alt text-success"></i></div>
                            <div class="timeline-card">
                                <div class="timeline-head">
                                    <span>نشر مدونة جديدة</span>
                                    <small class="text-muted">منذ ساعة</small>
                                </div>
                                <div class="timeline-body">
                                    قام <strong>محمد علي</strong> بنشر مدونة جديدة: <strong>أنظمة العمل الجديدة</strong>
                                </div>
                            </div>
                        </li>
                        <li class="timeline-item">
                            <div class="timeline-badge"><i class="fas fa-edit text-warning"></i></div>
                            <div class="timeline-card">
                                <div class="timeline-head">
                                    <span>تعديل نظام</span>
                                    <small class="text-muted">منذ 3 ساعات</small>
                                </div>
                                <div class="timeline-body">
                                    قام <strong>أحمد محمد</strong> بتعديل نظام: <strong>نظام العمل</strong>
                                </div>
                            </div>
                        </li>
                        <li class="timeline-item">
                            <div class="timeline-badge"><i class="fas fa-user-times text-danger"></i></div>
                            <div class="timeline-card">
                                <div class="timeline-head">
                                    <span>حذف مستخدم</span>
                                    <small class="text-muted">منذ يوم</small>
                                </div>
                                <div class="timeline-body">
                                    قام <strong>أحمد محمد</strong> بحذف المستخدم: <strong>يوسف خالد</strong>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- نافذة منبثقة لإضافة مستخدم جديد -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">إضافة مستخدم جديد</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addUserForm">
                    <div class="mb-3">
                        <label for="username" class="form-label">اسم المستخدم</label>
                        <input type="text" class="form-control" id="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">البريد الإلكتروني</label>
                        <input type="email" class="form-control" id="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">كلمة المرور</label>
                        <input type="password" class="form-control" id="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">تأكيد كلمة المرور</label>
                        <input type="password" class="form-control" id="confirmPassword" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">الدور</label>
                        <select class="form-select" id="role" required>
                            <option value="" selected disabled>اختر دور</option>
                            <option value="admin">مدير</option>
                            <option value="writer">كاتب</option>
                            <option value="editor">محرر</option>
                        </select>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="activeStatus" checked>
                        <label class="form-check-label" for="activeStatus">حساب نشط</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-primary" id="saveUserBtn">حفظ المستخدم</button>
            </div>
        </div>
    </div>
</div>

<!-- نافذة منبثقة لتعديل المستخدم -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">تعديل المستخدم</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editUserForm">
                    <input type="hidden" id="userId">
                    <div class="mb-3">
                        <label for="editUsername" class="form-label">اسم المستخدم</label>
                        <input type="text" class="form-control" id="editUsername" required>
                    </div>
                    <div class="mb-3">
                        <label for="editEmail" class="form-label">البريد الإلكتروني</label>
                        <input type="email" class="form-control" id="editEmail" required>
                    </div>
                    <div class="mb-3">
                        <label for="editPassword" class="form-label">كلمة المرور (اتركه فارغاً إذا لم ترد تغييرها)</label>
                        <input type="password" class="form-control" id="editPassword">
                    </div>
                    <div class="mb-3">
                        <label for="editRole" class="form-label">الدور</label>
                        <select class="form-select" id="editRole" required>
                            <option value="admin">مدير</option>
                            <option value="writer">كاتب</option>
                            <option value="editor">محرر</option>
                        </select>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="editActiveStatus">
                        <label class="form-check-label" for="editActiveStatus">حساب نشط</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-primary" id="updateUserBtn">تحديث المستخدم</button>
            </div>
        </div>
    </div>
</div>

<!-- نافذة منبثقة لتعديل الدور -->
<div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRoleModalLabel">تعديل صلاحيات الدور</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editRoleForm">
                    <input type="hidden" id="roleId">
                    <div class="mb-3">
                        <label for="roleName" class="form-label">اسم الدور</label>
                        <input type="text" class="form-control" id="roleName" required>
                    </div>
                    <div class="mb-3">
                        <label for="roleDescription" class="form-label">وصف الدور</label>
                        <textarea class="form-control" id="roleDescription" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">الصلاحيات</label>
                        <div class="permissions-list">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="permViewSystems">
                                <label class="form-check-label" for="permViewSystems">
                                    عرض الأنظمة
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="permAddSystems">
                                <label class="form-check-label" for="permAddSystems">
                                    إضافة أنظمة
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="permEditSystems">
                                <label class="form-check-label" for="permEditSystems">
                                    تعديل الأنظمة
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="permDeleteSystems">
                                <label class="form-check-label" for="permDeleteSystems">
                                    حذف الأنظمة
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="permViewBlogs">
                                <label class="form-check-label" for="permViewBlogs">
                                    عرض المدونات
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="permAddBlogs">
                                <label class="form-check-label" for="permAddBlogs">
                                    إضافة مدونات
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="permEditBlogs">
                                <label class="form-check-label" for="permEditBlogs">
                                    تعديل المدونات
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="permDeleteBlogs">
                                <label class="form-check-label" for="permDeleteBlogs">
                                    حذف المدونات
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="permManageUsers">
                                <label class="form-check-label" for="permManageUsers">
                                    إدارة المستخدمين
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-primary" id="updateRoleBtn">تحديث الدور</button>
            </div>
        </div>
    </div>
</div>
