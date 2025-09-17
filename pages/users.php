<?php
// الاتصال بقاعدة البيانات
$host = "localhost";
$dbname = "u552468652_blog_system";
$user = "u552468652_blog_system";
$pass = "Blog12345@#"; // عدل حسب قاعدة بياناتك
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("فشل الاتصال بقاعدة البيانات: " . $e->getMessage());
}

// معالجة AJAX
if(isset($_POST['action'])){
    $action = $_POST['action'];

    if($action=='getUsers'){
        $stmt = $pdo->query("SELECT * FROM users");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        exit;
    }

    if($action=='addUser'){
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $role = $_POST['role'];
        $status = isset($_POST['status']) && $_POST['status']=='active' ? 'active':'inactive';
        $stmt = $pdo->prepare("INSERT INTO users (username,email,password,full_name,role,status) VALUES (?,?,?,?,?,?)");
        $stmt->execute([$username,$email,$password,$username,$role,$status]);
        // سجل النشاط
        $stmt2 = $pdo->prepare("INSERT INTO activity_log (user_id,action,description) VALUES (?,?,?)");
        $stmt2->execute([1,'add_user',"تم إضافة المستخدم $username"]);
        echo json_encode(['status'=>'success']);
        exit;
    }

    if($action=='deleteUser'){
        $id = $_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM users WHERE id=?");
        $stmt->execute([$id]);
        $stmt2 = $pdo->prepare("INSERT INTO activity_log (user_id,action,description) VALUES (?,?,?)");
        $stmt2->execute([1,'delete_user',"تم حذف المستخدم ID $id"]);
        echo json_encode(['status'=>'success']);
        exit;
    }

    if($action=='updateUser'){
        $id = $_POST['id'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        $status = isset($_POST['status']) && $_POST['status']=='active' ? 'active':'inactive';
        if(!empty($_POST['password'])){
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $stmt = $pdo->prepare("UPDATE users SET username=?,email=?,role=?,status=?,password=? WHERE id=?");
            $stmt->execute([$username,$email,$role,$status,$password,$id]);
        } else {
            $stmt = $pdo->prepare("UPDATE users SET username=?,email=?,role=?,status=? WHERE id=?");
            $stmt->execute([$username,$email,$role,$status,$id]);
        }
        $stmt2 = $pdo->prepare("INSERT INTO activity_log (user_id,action,description) VALUES (?,?,?)");
        $stmt2->execute([1,'update_user',"تم تعديل المستخدم $username"]);
        echo json_encode(['status'=>'success']);
        exit;
    }

    if($action=='getRoles'){
        $stmt = $pdo->query("SELECT * FROM roles");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        exit;
    }

    if($action=='getActivity'){
        $stmt = $pdo->query("SELECT * FROM activity_log ORDER BY created_at DESC LIMIT 10");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>المستخدمين والصلاحيات</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
.user-avatar {width:40px;height:40px;border-radius:50%;background:#007bff;color:#fff;display:flex;align-items:center;justify-content:center;margin-right:10px;}
.timeline {list-style:none;padding-left:0;}
.timeline-item{position:relative;margin-bottom:20px;}
.timeline-badge{width:30px;height:30px;border-radius:50%;display:flex;align-items:center;justify-content:center;position:absolute;left:-15px;top:0;}
.timeline-card{margin-left:30px;background:#f8f9fa;padding:10px;border-radius:5px;}
</style>
</head>
<body class="p-4">

<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">المستخدمين والصلاحيات</h4>
                    <button id="addUserBtn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                        <i class="fas fa-plus"></i> إضافة مستخدم جديد
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="usersTable">
                            <thead>
                                <tr>
                                    <th>المستخدم</th>
                                    <th>البريد الإلكتروني</th>
                                    <th>الدور</th>
                                    <th>الحالة</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- الأدوار والصلاحيات -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><h4>الأدوار والصلاحيات</h4></div>
                <div class="card-body" id="rolesList"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><h4>سجل النشاطات</h4></div>
                <div class="card-body" id="activityLog"></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal إضافة مستخدم -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
<div class="modal-dialog"><div class="modal-content">
<div class="modal-header">
<h5 class="modal-title">إضافة مستخدم جديد</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body">
<form id="addUserForm">
<div class="mb-3"><label>اسم المستخدم</label><input type="text" class="form-control" id="username" required></div>
<div class="mb-3"><label>البريد الإلكتروني</label><input type="email" class="form-control" id="email" required></div>
<div class="mb-3"><label>كلمة المرور</label><input type="password" class="form-control" id="password" required></div>
<div class="mb-3"><label>تأكيد كلمة المرور</label><input type="password" class="form-control" id="confirmPassword" required></div>
<div class="mb-3"><label>الدور</label>
<select class="form-select" id="role" required>
<option value="" disabled selected>اختر دور</option>
<option value="admin">مدير</option>
<option value="writer">كاتب</option>
<option value="editor">محرر</option>
</select></div>
<div class="mb-3 form-check"><input type="checkbox" class="form-check-input" id="activeStatus" checked><label class="form-check-label">حساب نشط</label></div>
</form>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
<button type="button" class="btn btn-primary" id="saveUserBtn">حفظ المستخدم</button>
</div>
</div></div></div>

<!-- Modal تعديل مستخدم -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
<div class="modal-dialog"><div class="modal-content">
<div class="modal-header">
<h5 class="modal-title">تعديل المستخدم</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body">
<form id="editUserForm">
<input type="hidden" id="userId">
<div class="mb-3"><label>اسم المستخدم</label><input type="text" class="form-control" id="editUsername" required></div>
<div class="mb-3"><label>البريد الإلكتروني</label><input type="email" class="form-control" id="editEmail" required></div>
<div class="mb-3"><label>كلمة المرور (فارغ إذا لا تغيير)</label><input type="password" class="form-control" id="editPassword"></div>
<div class="mb-3"><label>الدور</label>
<select class="form-select" id="editRole">
<option value="admin">مدير</option>
<option value="writer">كاتب</option>
<option value="editor">محرر</option>
</select></div>
<div class="mb-3 form-check"><input type="checkbox" class="form-check-input" id="editActiveStatus"><label class="form-check-label">حساب نشط</label></div>
</form>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
<button type="button" class="btn btn-primary" id="updateUserBtn">تحديث المستخدم</button>
</div>
</div></div></div>

<script>
// تحميل المستخدمين
function loadUsers(){
    $.post('users_dashboard.php',{action:'getUsers'}, function(data){
        let tbody = '';
        data.forEach(u=>{
            tbody += `<tr data-id="${u.id}">
                <td>${u.full_name}</td>
                <td>${u.email}</td>
                <td>${u.role}</td>
                <td>${u.status}</td>
                <td>
                <button class="btn btn-sm btn-info edit-user-btn">تعديل</button>
                <button class="btn btn-sm btn-danger delete-user-btn">حذف</button>
                </td></tr>`;
        });
        $('#usersTable tbody').html(tbody);
    },'json');
}

// تحميل الأدوار
function loadRoles(){
    $.post('users_dashboard.php',{action:'getRoles'}, function(data){
        let html='';
        data.forEach(r=>{
            html+=`<div class="role-item mb-3"><h5>${r.name}</h5><p>${r.description}</p></div>`;
        });
        $('#rolesList').html(html);
    },'json');
}

// تحميل سجل النشاط
function loadActivity(){
    $.post('users_dashboard.php',{action:'getActivity'}, function(data){
        let html='<ul class="timeline">';
        data.forEach(a=>{
            html+=`<li class="timeline-item"><div class="timeline-card">${a.action} - ${a.description}</div></li>`;
        });
        html+='</ul>';
        $('#activityLog').html(html);
    },'json');
}

$(document).ready(function(){
    loadUsers();
    loadRoles();
    loadActivity();

    // إضافة مستخدم
    $('#saveUserBtn').click(function(){
        if($('#password').val() != $('#confirmPassword').val()){alert('كلمة المرور غير متطابقة'); return;}
        $.post('users_dashboard.php',{
            action:'addUser',
            username:$('#username').val(),
            email:$('#email').val(),
            password:$('#password').val(),
            role:$('#role').val(),
            status:$('#activeStatus').is(':checked')?'active':'inactive'
        }, function(res){
            if(res.status=='success'){loadUsers(); $('#addUserModal').modal('hide');}
        },'json');
    });

    // حذف مستخدم
    $(document).on('click','.delete-user-btn',function(){
        if(!confirm('هل تريد الحذف؟')) return;
        let id = $(this).closest('tr').data('id');
        $.post('users_dashboard.php',{action:'deleteUser',id:id}, function(res){
            if(res.status=='success') loadUsers();
        },'json');
    });

    // فتح تعديل مستخدم
    $(document).on('click','.edit-user-btn',function(){
        let row=$(this).closest('tr');
        $('#userId').val(row.data('id'));
        $('#editUsername').val(row.find('td:eq(0)').text());
        $('#editEmail').val(row.find('td:eq(1)').text());
        $('#editRole').val(row.find('td:eq(2)').text());
        $('#editActiveStatus').prop('checked', row.find('td:eq(3)').text()=='active');
        $('#editUserModal').modal('show');
    });

    // تحديث مستخدم
    $('#updateUserBtn').click(function(){
        $.post('users_dashboard.php',{
            action:'updateUser',
            id:$('#userId').val(),
            username:$('#editUsername').val(),
            email:$('#editEmail').val(),
            password:$('#editPassword').val(),
            role:$('#editRole').val(),
            status:$('#editActiveStatus').is(':checked')?'active':'inactive'
        }, function(res){
            if(res.status=='success'){loadUsers(); $('#editUserModal').modal('hide');}
        },'json');
    });
});
</script>
</body>
</html>
