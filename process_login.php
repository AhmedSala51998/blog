<?php
session_start();

// الاتصال بقاعدة البيانات
require_once 'config.php';

// التحقق من إرسال النموذج
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    // استعلام للتحقق من وجود المستخدم
    $sql = "SELECT id, username, password, role FROM users WHERE username = ?";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $param_username);

        $param_username = $username;

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) == 1) {                    
                mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $role);
                if (mysqli_stmt_fetch($stmt)) {
                    if (password_verify($password, $hashed_password)) {
                        session_start();

                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $id;
                        $_SESSION["username"] = $username;
                        $_SESSION["role"] = $role;

                        header("location: index.php");
                    } else {
                        header("location: login.php?error=اسم المستخدم أو كلمة المرور غير صحيحة");
                    }
                }
            } else {
                header("location: login.php?error=اسم المستخدم أو كلمة المرور غير صحيحة");
            }
        } else {
            echo "حدث خطأ. يرجى المحاولة مرة أخرى لاحقاً.";
        }
        mysqli_stmt_close($stmt);
    }
}

mysqli_close($conn);
?>
