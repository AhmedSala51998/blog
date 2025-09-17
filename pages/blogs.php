<?php
$host = 'localhost';
$db   = 'u552468652_blog_system';
$user = 'u552468652_blog_system';
$pass = 'Blog12345@#';
$conn = new mysqli($host, $user, $pass, $db);
$conn->set_charset("utf8");

// إضافة مدونة جديدة
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_blog') {
    $title       = $conn->real_escape_string($_POST['title']);
    $category_id = (int)$_POST['category_id'];
    $content     = $conn->real_escape_string($_POST['content']);
    $tags        = $conn->real_escape_string($_POST['tags']);
    $publish     = isset($_POST['publish']) ? 'published' : 'draft';
    $author_id   = 1; // مثال ثابت

    $system_id   = !empty($_POST['system_id']) ? (int)$_POST['system_id'] : null;
    $law_id      = !empty($_POST['law_id']) ? (int)$_POST['law_id'] : null;
    $article_id  = !empty($_POST['article_id']) ? (int)$_POST['article_id'] : null;

    $sql = "INSERT INTO blogs (title, content, category_id, author_id, status, tags, system_reference, law_reference, article_reference)
            VALUES ('$title','$content',$category_id,$author_id,'$publish','$tags',".($system_id ?? 'NULL').",".($law_id ?? 'NULL').",".($article_id ?? 'NULL').")";
    $conn->query($sql);
    header("Location: blogs.php?added=1");
    exit;
}

// استخراج النص من PDF
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['pdf'])) {
    $file = $_FILES['pdf']['tmp_name'];
    $output = '';
    
    if (file_exists('/usr/bin/pdftotext')) {
        $tmpFile = tempnam(sys_get_temp_dir(), 'pdf');
        move_uploaded_file($file, $tmpFile);
        $output = shell_exec("/usr/bin/pdftotext " . escapeshellarg($tmpFile) . " -");
        unlink($tmpFile);
    } else {
        $output = "الرجاء تثبيت pdftotext على السيرفر لاستخراج النص";
    }
    
    echo $output;
    exit;
}

// جلب الأنظمة
$systems = $conn->query("SELECT * FROM systems ORDER BY name ASC")->fetch_all(MYSQLI_ASSOC);

// جلب المدونات
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$where  = $search ? "WHERE b.title LIKE '%$search%'" : '';
$blogs  = $conn->query("
    SELECT b.*, c.name AS category
    FROM blogs b 
    JOIN categories c ON b.category_id = c.id
    $where
    ORDER BY b.created_at DESC
")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<title>إضافة مدونة جديدة</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
</head>
<body>
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">إضافة مدونة جديدة</h4>
                </div>
                <div class="card-body">
                    <form id="blogForm" method="POST" action="blogs.php">
                        <input type="hidden" name="action" value="add_blog">
                        <div class="mb-3">
                            <label for="blogTitle" class="form-label">عنوان المدونة</label>
                            <input type="text" class="form-control" id="blogTitle" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="blogCategory" class="form-label">تصنيف المدونة</label>
                            <select class="form-select" id="blogCategory" name="category_id" required>
                                <option value="" selected disabled>اختر تصنيف</option>
                                <option value="1">قانوني</option>
                                <option value="2">اجتماعي</option>
                                <option value="3">اقتصادي</option>
                                <option value="4">ثقافي</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="blogContent" class="form-label">محتوى المدونة</label>
                            <textarea class="form-control" id="blogContent" name="content" rows="10" required></textarea>
                        </div>
                        <div class="mb-3 d-flex justify-content-between">
                            <div>
                                <button type="button" class="btn btn-secondary me-2" id="extractPdfBtn">
                                    <i class="fas fa-file-pdf"></i> استخراج من PDF
                                </button>
                                <input type="file" id="pdfFile" accept=".pdf" style="display: none;">
                            </div>
                            <div>
                                <button type="button" class="btn btn-outline-primary me-2" id="addLinkBtn">
                                    <i class="fas fa-link"></i> إضافة رابط
                                </button>
                                <button type="button" class="btn btn-outline-primary me-2" id="addVideoBtn">
                                    <i class="fas fa-video"></i> إضافة فيديو
                                </button>
                                <button type="button" class="btn btn-outline-primary" id="addImageBtn">
                                    <i class="fas fa-image"></i> إضافة صورة
                                </button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="systemSelect" class="form-label">الاستدلال من مكتب العمل</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <select class="form-select mb-2" id="systemSelect" name="system_id">
                                        <option value="" selected disabled>اختر نظام</option>
                                        <?php foreach($systems as $sys): ?>
                                        <option value="<?= $sys['id'] ?>"><?= $sys['name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select class="form-select mb-2" id="lawSelect" name="law_id" disabled>
                                        <option value="" selected disabled>اختر مادة</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select class="form-select mb-2" id="articleSelect" name="article_id" disabled>
                                        <option value="" selected disabled>اختر جزء</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="blogTags" class="form-label">الكلمات المفتاحية</label>
                            <input type="text" class="form-control" id="blogTags" name="tags" placeholder="افصل بين الكلمات بفاصلة">
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="publishNow" name="publish">
                            <label class="form-check-label" for="publishNow">نشر الآن</label>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary" id="previewBtn">معاينة</button>
                            <button type="submit" class="btn btn-primary">حفظ المدونة</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- المدونات المحفوظة -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">المدونات المحفوظة</h4>
                    <div>
                        <input type="text" class="form-control" id="searchBlogs" placeholder="بحث في المدونات...">
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>العنوان</th>
                                    <th>التصنيف</th>
                                    <th>تاريخ الإنشاء</th>
                                    <th>الحالة</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($blogs as $b): ?>
                                <tr>
                                    <td><?= $b['title'] ?></td>
                                    <td><?= $b['category'] ?></td>
                                    <td><?= date('Y-m-d', strtotime($b['created_at'])) ?></td>
                                    <td>
                                        <span class="badge <?= $b['status']=='published'?'bg-success':'bg-warning' ?>">
                                            <?= $b['status']=='published'?'منشور':'مسودة' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-info"><i class="fas fa-eye"></i></button>
                                        <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- معاينة المدونة -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="previewModalLabel">معاينة المدونة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <h3 id="previewTitle"></h3>
                <div id="previewContent"></div>
                <div class="mt-3">
                    <span class="badge bg-primary" id="previewCategory"></span>
                    <span class="badge bg-info" id="previewDate"></span>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function(){

    // استخراج نص PDF
    $('#extractPdfBtn').click(function(){
        var file = $('#pdfFile')[0].files[0];
        if(!file){ alert('اختر ملف PDF'); return; }
        var formData = new FormData();
        formData.append('pdf', file);
        $.ajax({
            url: 'blogs.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(res){ $('#blogContent').val(res); }
        });
    });

    // معاينة المدونة
    $('#previewBtn').click(function(){
        $('#previewTitle').text($('#blogTitle').val());
        $('#previewContent').text($('#blogContent').val());
        $('#previewCategory').text($('#blogCategory option:selected').text());
        $('#previewDate').text(new Date().toLocaleDateString());
        var modal = new bootstrap.Modal(document.getElementById('previewModal'));
        modal.show();
    });

    // تحميل PDF عند الضغط على زر
    $('#extractPdfBtn').prev('input[type=file]').click(function(){});
});
</script>
</body>
</html>
