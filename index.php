<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم المدونة</title>
    <link rel="stylesheet" href="assets/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- الشريط الجانبي -->
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                        <h3>لوحة التحكم</h3>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="index.php?page=systems">
                                <i class="fas fa-gavel"></i> الأنظمة والقوانين
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?page=blogs">
                                <i class="fas fa-blog"></i> المدونات
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?page=users">
                                <i class="fas fa-users"></i> المستخدمين والصلاحيات
                            </a>
                        </li>
                        <li class="nav-item mt-auto">
                            <a class="nav-link" href="logout.php">
                                <i class="fas fa-sign-out-alt"></i> تسجيل الخروج
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- المحتوى الرئيسي -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">
                        <?php
                        $page = isset($_GET['page']) ? $_GET['page'] : 'systems';
                        switch ($page) {
                            case 'systems':
                                echo 'الأنظمة والقوانين';
                                break;
                            case 'blogs':
                                echo 'المدونات';
                                break;
                            case 'users':
                                echo 'المستخدمين والصلاحيات';
                                break;
                            default:
                                echo 'لوحة التحكم';
                        }
                        ?>
                    </h1>
                </div>

                <div class="content">
                    <?php
                    if (isset($_GET['page'])) {
                        $page = $_GET['page'];
                        switch ($page) {
                            case 'systems':
                                include 'pages/systems.php';
                                break;
                            case 'blogs':
                                include 'pages/blogs.php';
                                break;
                            case 'users':
                                include 'pages/users.php';
                                break;
                            default:
                                include 'pages/systems.php';
                        }
                    } else {
                        include 'pages/systems.php';
                    }
                    ?>
                </div>
            </main>
        </div>
    </div>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>
