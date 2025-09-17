$(document).ready(function() {
    // تفعيل الروابط في الشريط الجانبي
    $('.nav-link').on('click', function() {
        $('.nav-link').removeClass('active');
        $(this).addClass('active');
    });

    // وظائف صفحة الأنظمة والقوانين
    let lawCounter = 0;
    let articleCounter = 0;

    // إضافة نظام جديد
    $('#addSystemBtn').on('click', function() {
        const systemName = prompt('أدخل اسم النظام:');
        if (systemName) {
            addSystem(systemName);
        }
    });

    function addSystem(name) {
        lawCounter = 0;
        const systemId = 'system-' + Date.now();
        const systemHtml = `
            <div class="system-item" id="${systemId}">
                <div class="system-header">
                    <h4 class="system-title">${name}</h4>
                    <div>
                        <button class="btn btn-sm btn-success add-law-btn" data-system="${systemId}">إضافة مادة</button>
                        <button class="btn btn-sm btn-danger delete-system-btn" data-system="${systemId}">حذف النظام</button>
                    </div>
                </div>
                <div class="laws-container" id="${systemId}-laws"></div>
            </div>
        `;
        $('#systemsContainer').append(systemHtml);
    }

    // إضافة مادة جديدة
    $(document).on('click', '.add-law-btn', function() {
        const systemId = $(this).data('system');
        articleCounter = 0;
        const lawName = prompt('أدخل اسم المادة:');
        if (lawName) {
            addLaw(systemId, lawName);
        }
    });

    function addLaw(systemId, name) {
        const lawId = 'law-' + Date.now();
        const lawHtml = `
            <div class="law-item" id="${lawId}">
                <div class="law-header">
                    <h5 class="law-title">${name}</h5>
                    <div>
                        <button class="btn btn-sm btn-info add-article-btn" data-law="${lawId}">إضافة جزء</button>
                        <button class="btn btn-sm btn-danger delete-law-btn" data-law="${lawId}">حذف المادة</button>
                    </div>
                </div>
                <div class="articles-container" id="${lawId}-articles"></div>
            </div>
        `;
        $(`#${systemId}-laws`).append(lawHtml);
    }

    // إضافة جزء جديد
    $(document).on('click', '.add-article-btn', function() {
        const lawId = $(this).data('law');
        articleCounter++;
        const articleContent = prompt('أدخل نص الجزء:');
        if (articleContent) {
            addArticle(lawId, articleContent);
        }
    });

    function addArticle(lawId, content) {
        const articleId = 'article-' + Date.now();
        const articleHtml = `
            <div class="article-item" id="${articleId}">
                <div class="article-header">
                    <h6>الجزء ${articleCounter}</h6>
                    <button class="btn btn-sm btn-danger delete-article-btn" data-article="${articleId}">حذف</button>
                </div>
                <div class="article-content">${content}</div>
            </div>
        `;
        $(`#${lawId}-articles`).append(articleHtml);
    }

    // حذف نظام
    $(document).on('click', '.delete-system-btn', function() {
        if (confirm('هل أنت متأكد من حذف هذا النظام؟')) {
            const systemId = $(this).data('system');
            $(`#${systemId}`).remove();
        }
    });

    // حذف مادة
    $(document).on('click', '.delete-law-btn', function() {
        if (confirm('هل أنت متأكد من حذف هذه المادة؟')) {
            const lawId = $(this).data('law');
            $(`#${lawId}`).remove();
        }
    });

    // حذف جزء
    $(document).on('click', '.delete-article-btn', function() {
        if (confirm('هل أنت متأكد من حذف هذا الجزء؟')) {
            const articleId = $(this).data('article');
            $(`#${articleId}`).remove();
        }
    });

    // وظائف صفحة المدونات
    $('#extractPdfBtn').on('click', function() {
        // سيتم تنفيذ استخراج النص من PDF هنا
        alert('سيتم استخراج النص من الملف المرفق');
    });

    $('#addLinkBtn').on('click', function() {
        const linkUrl = prompt('أدخل الرابط:');
        if (linkUrl) {
            const linkText = prompt('أدخل نص الرابط:');
            if (linkText) {
                $('#blogContent').append(`<a href="${linkUrl}" target="_blank">${linkText}</a> `);
            }
        }
    });

    $('#addVideoBtn').on('click', function() {
        const videoUrl = prompt('أدخل رابط الفيديو:');
        if (videoUrl) {
            $('#blogContent').append(`<br><iframe width="560" height="315" src="${videoUrl}" frameborder="0" allowfullscreen></iframe><br>`);
        }
    });

    $('#addImageBtn').on('click', function() {
        const imageUrl = prompt('أدخل رابط الصورة:');
        if (imageUrl) {
            const altText = prompt('أدخل النص البديل للصورة:');
            $('#blogContent').append(`<br><img src="${imageUrl}" alt="${altText || ''}" style="max-width: 100%;"><br>`);
        }
    });

    // تحديث حقل الاستدلال من مكتب العمل عند تغيير النظام أو المادة
    $('#systemSelect').on('change', function() {
        const systemId = $(this).val();
        // سيتم تحديث قائمة المواد بناءً على النظام المحدد
        updateLawSelect(systemId);
    });

    $('#lawSelect').on('change', function() {
        const lawId = $(this).val();
        // سيتم تحديث قائمة الأجزاء بناءً على المادة المحددة
        updateArticleSelect(lawId);
    });

    function updateLawSelect(systemId) {
        // سيتم تحديث قائمة المواد بناءً على النظام المحدد
        // هذا مجرد مثال وسيتم استبداله بالكود الفعلي
        $('#lawSelect').html('<option value="">اختر مادة</option>');
    }

    function updateArticleSelect(lawId) {
        // سيتم تحديث قائمة الأجزاء بناءً على المادة المحددة
        // هذا مجرد مثال وسيتم استبداله بالكود الفعلي
        $('#articleSelect').html('<option value="">اختر جزء</option>');
    }

    // وظائف صفحة المستخدمين
    $('#addUserBtn').on('click', function() {
        // سيتم فتح نموذج إضافة مستخدم جديد
        $('#addUserModal').modal('show');
    });

    $('#saveUserBtn').on('click', function() {
        const username = $('#username').val();
        const email = $('#email').val();
        const password = $('#password').val();
        const role = $('#role').val();

        if (username && email && password && role) {
            // سيتم حفظ المستخدم الجديد في قاعدة البيانات
            alert('تم حفظ المستخدم بنجاح');
            $('#addUserModal').modal('hide');
            // سيتم تحديث قائمة المستخدمين
        } else {
            alert('يرجى ملء جميع الحقول');
        }
    });
});
