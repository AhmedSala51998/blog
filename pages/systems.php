<?php
// systems.php
session_start();

// --------- إعداد اتصال قاعدة البيانات (عدّل القيم هنا) ----------
$DB_HOST = 'localhost';
$DB_NAME = 'u552468652_blog_system';
$DB_USER = 'u552468652_blog_system';
$DB_PASS = 'Blog12345@#';

try {
    $pdo = new PDO("mysql:host={$DB_HOST};dbname={$DB_NAME};charset=utf8mb4", $DB_USER, $DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    // لو تم استدعاء ملف عبر AJAX، نعيد JSON خطأ، وإلا نطبع رسالة
    if (isset($_GET['action']) || isset($_POST['action'])) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['error' => 'DB connection failed', 'message' => $e->getMessage()]);
        exit;
    } else {
        die("فشل الاتصال بقاعدة البيانات: " . htmlspecialchars($e->getMessage()));
    }
}

// --------- توكن CSRF بسيط ---------
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(24));
}
$CSRF = $_SESSION['csrf_token'];

// --------- دوال مساعدة ---------
function json_response($data) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}
function require_csrf() {
    $passed = false;
    $hdr = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? null;
    if ($hdr && isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $hdr)) $passed = true;
    // دعم إرسال داخل JSON body
    $input = json_decode(file_get_contents('php://input'), true);
    if (!$passed && isset($input['csrf_token']) && isset($_SESSION['csrf_token']) &&
        hash_equals($_SESSION['csrf_token'], $input['csrf_token'])) $passed = true;

    if (!$passed) {
        json_response(['error' => 'invalid_csrf']);
    }
}

// --------- API (إذا في parameter action نعمل JSON API) ---------
$action = $_GET['action'] ?? $_POST['action'] ?? null;
if ($action) {
    // جميع عمليات الكتابة تتحقق من CSRF
    try {
        switch ($action) {
            case 'getSystems':
                $stmt = $pdo->query("SELECT s.*, u.username AS creator FROM systems s LEFT JOIN users u ON u.id = s.created_by ORDER BY s.created_at DESC");
                $rows = $stmt->fetchAll();
                json_response($rows);
                break;

            case 'addSystem':
                require_csrf();
                $data = json_decode(file_get_contents('php://input'), true);
                $name = trim($data['name'] ?? '');
                $description = trim($data['description'] ?? '');
                if ($name === '') json_response(['error' => 'empty_name']);
                // created_by: غيّره لربط المستخدم المسجل فعليًا
                $created_by = $_SESSION['user_id'] ?? 1;
                $stmt = $pdo->prepare("INSERT INTO systems (name, description, created_by) VALUES (:name, :desc, :created_by)");
                $stmt->execute([':name' => $name, ':desc' => $description, ':created_by' => $created_by]);
                json_response(['success' => true, 'id' => $pdo->lastInsertId()]);
                break;

            case 'getLaws':
                $system_id = (int)($_GET['system_id'] ?? 0);
                if (!$system_id) json_response([]);
                $stmt = $pdo->prepare("SELECT * FROM laws WHERE system_id = ? ORDER BY created_at DESC");
                $stmt->execute([$system_id]);
                json_response($stmt->fetchAll());
                break;

            case 'addLaw':
                require_csrf();
                $data = json_decode(file_get_contents('php://input'), true);
                $system_id = (int)($data['system_id'] ?? 0);
                $name = trim($data['name'] ?? '');
                $description = trim($data['description'] ?? '');
                if (!$system_id || $name === '') json_response(['error' => 'invalid_input']);
                $stmt = $pdo->prepare("INSERT INTO laws (system_id, name, description) VALUES (:sid, :name, :desc)");
                $stmt->execute([':sid' => $system_id, ':name' => $name, ':desc' => $description]);
                json_response(['success' => true, 'id' => $pdo->lastInsertId()]);
                break;

            case 'getArticles':
                $law_id = (int)($_GET['law_id'] ?? 0);
                if (!$law_id) json_response([]);
                $stmt = $pdo->prepare("SELECT * FROM articles WHERE law_id = ? ORDER BY number ASC, created_at ASC");
                $stmt->execute([$law_id]);
                json_response($stmt->fetchAll());
                break;

            case 'addArticle':
                require_csrf();
                $data = json_decode(file_get_contents('php://input'), true);
                $law_id = (int)($data['law_id'] ?? 0);
                $number = (int)($data['number'] ?? 0);
                $content = trim($data['content'] ?? '');
                if (!$law_id || $number <= 0 || $content === '') json_response(['error' => 'invalid_input']);
                $stmt = $pdo->prepare("INSERT INTO articles (law_id, number, content) VALUES (:lid, :num, :cont)");
                $stmt->execute([':lid' => $law_id, ':num' => $number, ':cont' => $content]);
                json_response(['success' => true, 'id' => $pdo->lastInsertId()]);
                break;

            // خيارات إضافية: حذف/تعديل لو احتجت
            default:
                json_response(['error' => 'unknown_action']);
        }
    } catch (Exception $e) {
        json_response(['error' => 'exception', 'message' => $e->getMessage()]);
    }
    // نهاية API branch
    exit;
}

// --------- إذا لا يوجد action نعرض الصفحة (HTML + JS) ----------
?><!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <title>الأنظمة والقوانين</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <style>
        body { background:#f6f7fb; font-family: "Tajawal", sans-serif; padding:20px; }
        .card { box-shadow: 0 4px 10px rgba(0,0,0,0.03); }
    </style>
    <meta name="csrf-token" content="<?php echo htmlspecialchars($CSRF); ?>">
</head>
<body>

<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">الأنظمة والقوانين</h4>
                    <button id="addSystemBtn" class="btn btn-primary">
                        <i class="fas fa-plus"></i> إضافة نظام جديد
                    </button>
                </div>
                <div class="card-body">
                    <div id="systemsContainer">
                        <div class="alert alert-info">
                            لا توجد أنظمة مضافة بعد. اضغط على "إضافة نظام جديد" للبدء.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- مودالات (نفس اللي ارسلتها) -->
<!-- إضافة نظام -->
<div class="modal fade" id="addSystemModal" tabindex="-1" aria-labelledby="addSystemModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">إضافة نظام جديد</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addSystemForm">
                    <div class="mb-3">
                        <label class="form-label">اسم النظام</label>
                        <input type="text" class="form-control" id="systemName" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">وصف النظام</label>
                        <textarea class="form-control" id="systemDescription" rows="3"></textarea>
                    </div>
                    <input type="hidden" id="csrf_inp_system" value="<?php echo htmlspecialchars($CSRF); ?>">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-primary" id="saveSystemBtn">حفظ النظام</button>
            </div>
        </div>
    </div>
</div>

<!-- إضافة مادة -->
<div class="modal fade" id="addLawModal" tabindex="-1" aria-labelledby="addLawModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">إضافة مادة جديدة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addLawForm">
                    <div class="mb-3">
                        <label class="form-label">اسم المادة</label>
                        <input type="text" class="form-control" id="lawName" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">وصف المادة</label>
                        <textarea class="form-control" id="lawDescription" rows="3"></textarea>
                    </div>
                    <input type="hidden" id="csrf_inp_law" value="<?php echo htmlspecialchars($CSRF); ?>">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-primary" id="saveLawBtn">حفظ المادة</button>
            </div>
        </div>
    </div>
</div>

<!-- إضافة جزء -->
<div class="modal fade" id="addArticleModal" tabindex="-1" aria-labelledby="addArticleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">إضافة جزء جديد</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addArticleForm">
                    <div class="mb-3">
                        <label class="form-label">رقم الجزء</label>
                        <input type="number" class="form-control" id="articleNumber" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">نص الجزء</label>
                        <textarea class="form-control" id="articleContent" rows="6" required></textarea>
                    </div>
                    <input type="hidden" id="csrf_inp_article" value="<?php echo htmlspecialchars($CSRF); ?>">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-primary" id="saveArticleBtn">حفظ الجزء</button>
            </div>
        </div>
    </div>
</div>

<!-- جافاسكربت -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    let currentSystemId = null;
    let currentLawId = null;

    function ajaxJSON(url, method = 'GET', body = null) {
        const opts = {
            method: method,
            headers: {}
        };
        if (method !== 'GET') {
            opts.headers['Content-Type'] = 'application/json; charset=utf-8';
            // إضافة توكن في الهيدر
            opts.headers['X-CSRF-TOKEN'] = CSRF_TOKEN;
        } else {
            opts.headers['X-CSRF-TOKEN'] = CSRF_TOKEN;
        }
        if (body) opts.body = JSON.stringify(body);
        return fetch(url, opts).then(r => r.json());
    }

    // تحميل الأنظمة والمواد والأجزاء
    function loadSystems() {
        ajaxJSON('systems.php?action=getSystems').then(data => {
            const container = $('#systemsContainer');
            container.empty();
            if (!Array.isArray(data) || data.length === 0) {
                container.html('<div class="alert alert-info">لا توجد أنظمة مضافة بعد. اضغط على "إضافة نظام جديد" للبدء.</div>');
                return;
            }
            data.forEach(sys => {
                const card = $(`
                    <div class="card mb-3">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-0">${escapeHtml(sys.name)}</h5>
                                <small class="text-muted">بواسطة: ${escapeHtml(sys.creator ?? '---')} - ${sys.created_at}</small>
                            </div>
                            <div>
                                <button class="btn btn-sm btn-success add-law" data-id="${sys.id}"><i class="fas fa-plus"></i> إضافة مادة</button>
                            </div>
                        </div>
                        <div class="card-body laws-container"></div>
                    </div>
                `);
                container.append(card);
                loadLaws(sys.id, card.find('.laws-container'));
            });
        }).catch(err=>{
            console.error(err);
            $('#systemsContainer').html('<div class="alert alert-danger">خطأ في جلب الأنظمة.</div>');
        });
    }

    function loadLaws(systemId, container) {
        ajaxJSON(`systems.php?action=getLaws&system_id=${systemId}`).then(data=>{
            container.empty();
            if (!Array.isArray(data) || data.length === 0) {
                container.html('<div class="text-muted">لا توجد مواد بعد.</div>');
                return;
            }
            data.forEach(law=>{
                const block = $(`
                    <div class="border rounded p-3 mb-2 bg-white">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <strong>${escapeHtml(law.name)}</strong>
                                <div class="text-muted small">${escapeHtml(law.description || '')}</div>
                            </div>
                            <div>
                                <button class="btn btn-sm btn-info add-article" data-id="${law.id}"><i class="fas fa-plus"></i> إضافة جزء</button>
                            </div>
                        </div>
                        <div class="articles-container mt-3"></div>
                    </div>
                `);
                container.append(block);
                loadArticles(law.id, block.find('.articles-container'));
            });
        }).catch(err=>{
            container.html('<div class="text-danger">خطأ في جلب المواد.</div>');
        });
    }

    function loadArticles(lawId, container) {
        ajaxJSON(`systems.php?action=getArticles&law_id=${lawId}`).then(data=>{
            container.empty();
            if (!Array.isArray(data) || data.length === 0) {
                container.html('<div class="text-muted">لا توجد أجزاء بعد.</div>');
                return;
            }
            data.forEach(a=>{
                const html = `<div class="p-2 mb-2 border rounded"><strong>${a.number}.</strong> ${escapeHtml(a.content)}</div>`;
                container.append(html);
            });
        }).catch(err=>{
            container.html('<div class="text-danger">خطأ في جلب الأجزاء.</div>');
        });
    }

    // فتح مودال إضافة نظام
    $('#addSystemBtn').on('click', ()=> {
        $('#systemName').val('');
        $('#systemDescription').val('');
        new bootstrap.Modal(document.getElementById('addSystemModal')).show();
    });

    $('#saveSystemBtn').on('click', ()=>{
        const name = $('#systemName').val().trim();
        const desc = $('#systemDescription').val().trim();
        if (!name) { alert('أدخل اسم النظام'); return; }
        const payload = { name, description: desc, csrf_token: CSRF_TOKEN };
        ajaxJSON('systems.php?action=addSystem', 'POST', payload).then(res=>{
            if (res.success) {
                bootstrap.Modal.getInstance(document.getElementById('addSystemModal')).hide();
                loadSystems();
            } else {
                alert('خطأ: ' + (res.error || JSON.stringify(res)));
            }
        });
    });

    // إضافة مادة
    $(document).on('click', '.add-law', function(){
        currentSystemId = $(this).data('id');
        $('#lawName').val('');
        $('#lawDescription').val('');
        new bootstrap.Modal(document.getElementById('addLawModal')).show();
    });
    $('#saveLawBtn').on('click', ()=>{
        const name = $('#lawName').val().trim();
        const desc = $('#lawDescription').val().trim();
        if (!currentSystemId) { alert('خطأ: النظام غير محدد'); return; }
        if (!name) { alert('أدخل اسم المادة'); return; }
        const payload = { system_id: currentSystemId, name, description: desc, csrf_token: CSRF_TOKEN };
        ajaxJSON('systems.php?action=addLaw', 'POST', payload).then(res=>{
            if (res.success) {
                bootstrap.Modal.getInstance(document.getElementById('addLawModal')).hide();
                loadSystems();
            } else {
                alert('خطأ: ' + (res.error || JSON.stringify(res)));
            }
        });
    });

    // إضافة جزء
    $(document).on('click', '.add-article', function(){
        currentLawId = $(this).data('id');
        $('#articleNumber').val('');
        $('#articleContent').val('');
        new bootstrap.Modal(document.getElementById('addArticleModal')).show();
    });
    $('#saveArticleBtn').on('click', ()=>{
        const number = parseInt($('#articleNumber').val(), 10);
        const content = $('#articleContent').val().trim();
        if (!currentLawId) { alert('خطأ: المادة غير محددة'); return; }
        if (!number || number <= 0) { alert('أدخل رقم جزء صحيح'); return; }
        if (!content) { alert('أدخل نص الجزء'); return; }
        const payload = { law_id: currentLawId, number, content, csrf_token: CSRF_TOKEN };
        ajaxJSON('systems.php?action=addArticle', 'POST', payload).then(res=>{
            if (res.success) {
                bootstrap.Modal.getInstance(document.getElementById('addArticleModal')).hide();
                loadSystems();
            } else {
                alert('خطأ: ' + (res.error || JSON.stringify(res)));
            }
        });
    });

    // هروب الأحرف لمنع XSS عند الإدراج في DOM كنص
    function escapeHtml(unsafe) {
        if (unsafe === null || unsafe === undefined) return '';
        return String(unsafe)
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    // تحميل البيانات عند البداية
    $(document).ready(function(){ loadSystems(); });
</script>
</body>
</html>
