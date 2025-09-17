<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    http_response_code(403);
    exit("غير مسموح");
}

require 'config.php';

$action = $_POST['action'] ?? '';

switch($action) {

    // إضافة نظام جديد
    case 'add_system':
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $user_id = $_SESSION['id'];

        if($name != '') {
            $stmt = $pdo->prepare("INSERT INTO systems (name, description, created_by) VALUES (?, ?, ?)");
            $stmt->execute([$name, $description, $user_id]);
            echo json_encode(['status' => 'success', 'message' => 'تم إضافة النظام']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'اسم النظام مطلوب']);
        }
        break;

    // جلب كل الأنظمة مع المواد الخاصة بها
    case 'get_systems':
        $stmt = $pdo->query("SELECT s.*, u.full_name as creator FROM systems s JOIN users u ON s.created_by = u.id ORDER BY s.created_at DESC");
        $systems = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach($systems as &$sys){
            $stmt2 = $pdo->prepare("SELECT * FROM laws WHERE system_id = ? ORDER BY created_at DESC");
            $stmt2->execute([$sys['id']]);
            $sys['laws'] = $stmt2->fetchAll(PDO::FETCH_ASSOC);
            foreach($sys['laws'] as &$law){
                $stmt3 = $pdo->prepare("SELECT * FROM articles WHERE law_id = ? ORDER BY number ASC");
                $stmt3->execute([$law['id']]);
                $law['articles'] = $stmt3->fetchAll(PDO::FETCH_ASSOC);
            }
        }

        echo json_encode($systems);
        break;

    // إضافة مادة جديدة
    case 'add_law':
        $system_id = $_POST['system_id'] ?? 0;
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');

        if($system_id && $name != '') {
            $stmt = $pdo->prepare("INSERT INTO laws (system_id, name, description) VALUES (?, ?, ?)");
            $stmt->execute([$system_id, $name, $description]);
            echo json_encode(['status' => 'success', 'message' => 'تم إضافة المادة']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'البيانات غير مكتملة']);
        }
        break;

    // إضافة جزء جديد
    case 'add_article':
        $law_id = $_POST['law_id'] ?? 0;
        $number = $_POST['number'] ?? 0;
        $content = trim($_POST['content'] ?? '');

        if($law_id && $number && $content != '') {
            $stmt = $pdo->prepare("INSERT INTO articles (law_id, number, content) VALUES (?, ?, ?)");
            $stmt->execute([$law_id, $number, $content]);
            echo json_encode(['status' => 'success', 'message' => 'تم إضافة الجزء']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'البيانات غير مكتملة']);
        }
        break;

    default:
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'الإجراء غير معروف']);
}
?>
