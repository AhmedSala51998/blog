<?php
session_start();

// إزالة جميع متغيرات الجلسة
$_SESSION = array();

// تدمير الجلسة
session_destroy();

// التوجيه إلى صفحة تسجيل الدخول
header("location: login.php");
exit;
?>
