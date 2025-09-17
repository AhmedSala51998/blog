<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">الأنظمة والقوانين</h4>
                    <button id="addSystemBtn" class="btn btn-primary"><i class="fas fa-plus"></i> إضافة نظام جديد</button>
                </div>
                <div class="card-body">
                    <div id="systemsContainer">
                        <div class="alert alert-info">لا توجد أنظمة مضافة بعد. اضغط على "إضافة نظام جديد" للبدء.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- مودال النظام -->
<div class="modal fade" id="addSystemModal" tabindex="-1" aria-labelledby="addSystemModalLabel" aria-hidden="true">
    <div class="modal-dialog"><div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">إضافة نظام جديد</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
            <button class="btn btn-primary" id="saveSystemBtn">حفظ النظام</button>
        </div>
    </div></div>
</div>

<!-- مودال المادة -->
<div class="modal fade" id="addLawModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog"><div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">إضافة مادة جديدة</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
            <button class="btn btn-primary" id="saveLawBtn">حفظ المادة</button>
        </div>
    </div></div>
</div>

<!-- مودال الجزء -->
<div class="modal fade" id="addArticleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog"><div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">إضافة جزء جديد</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <form id="addArticleForm">
                <div class="mb-3">
                    <label class="form-label">رقم الجزء</label>
                    <input type="number" class="form-control" id="articleNumber" min="1" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">نص الجزء</label>
                    <textarea class="form-control" id="articleContent" rows="5" required></textarea>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
            <button class="btn btn-primary" id="saveArticleBtn">حفظ الجزء</button>
        </div>
    </div></div>
</div>
<script>
    $(document).ready(function(){

    // فتح نافذة إضافة نظام
    $('#addSystemBtn').click(function(){
        $('#addSystemModal').modal('show');
    });

    // حفظ النظام الجديد
    $('#saveSystemBtn').click(function(){
        let name = $('#systemName').val();
        let description = $('#systemDescription').val();

        $.post('systems_actions.php', {action:'add_system', name:name, description:description}, function(res){
            res = JSON.parse(res);
            alert(res.message);
            if(res.status == 'success'){
                $('#addSystemModal').modal('hide');
                $('#addSystemForm')[0].reset();
                loadSystems();
            }
        });
    });

    // حفظ المادة الجديدة
    $('#saveLawBtn').click(function(){
        let system_id = $('#lawSystemId').val();
        let name = $('#lawName').val();
        let description = $('#lawDescription').val();

        $.post('systems_actions.php', {action:'add_law', system_id:system_id, name:name, description:description}, function(res){
            res = JSON.parse(res);
            alert(res.message);
            if(res.status == 'success'){
                $('#addLawModal').modal('hide');
                $('#addLawForm')[0].reset();
                loadSystems();
            }
        });
    });

    // حفظ الجزء الجديد
    $('#saveArticleBtn').click(function(){
        let law_id = $('#articleLawId').val();
        let number = $('#articleNumber').val();
        let content = $('#articleContent').val();

        $.post('systems_actions.php', {action:'add_article', law_id:law_id, number:number, content:content}, function(res){
            res = JSON.parse(res);
            alert(res.message);
            if(res.status == 'success'){
                $('#addArticleModal').modal('hide');
                $('#addArticleForm')[0].reset();
                loadSystems();
            }
        });
    });

    // جلب الأنظمة والمواد والأجزاء وعرضهم
    function loadSystems(){
        $.post('systems_actions.php', {action:'get_systems'}, function(res){
            let systems = JSON.parse(res);
            let html = '';

            if(systems.length){
                systems.forEach(sys => {
                    html += `<div class="card mb-3">
                        <div class="card-body">
                            <h5>${sys.name}</h5>
                            <p>${sys.description}</p>
                            <small>تم الإنشاء بواسطة: ${sys.creator}</small>
                            <div class="mt-2">`;

                    // زر إضافة مادة داخل النظام
                    html += `<button class="btn btn-sm btn-success mb-2 addLawBtn" data-systemid="${sys.id}">إضافة مادة</button>`;

                    // عرض المواد
                    if(sys.laws.length){
                        sys.laws.forEach(law => {
                            html += `<div class="card mb-2 ms-3">
                                <div class="card-body">
                                    <h6>${law.name}</h6>
                                    <p>${law.description}</p>
                                    <button class="btn btn-sm btn-primary addArticleBtn" data-lawid="${law.id}">إضافة جزء</button>`;

                            // عرض الأجزاء
                            if(law.articles.length){
                                law.articles.forEach(article => {
                                    html += `<div class="card ms-3 mb-1">
                                        <div class="card-body">
                                            <strong>الجزء ${article.number}:</strong> ${article.content}
                                        </div>
                                    </div>`;
                                });
                            }

                            html += `</div></div>`; // نهاية المادة
                        });
                    }

                    html += `</div></div>`; // نهاية النظام
                });
            } else {
                html = `<div class="alert alert-info">لا توجد أنظمة مضافة بعد</div>`;
            }

            $('#systemsContainer').html(html);
        });
    }

    loadSystems();

    // فتح مودال المادة مع تمرير system_id
    $(document).on('click', '.addLawBtn', function(){
        let systemId = $(this).data('systemid');
        $('#lawSystemId').remove(); // إزالة أي hidden input موجود
        $('#addLawForm').append(`<input type="hidden" id="lawSystemId" value="${systemId}">`);
        $('#addLawModal').modal('show');
    });

    // فتح مودال الجزء مع تمرير law_id
    $(document).on('click', '.addArticleBtn', function(){
        let lawId = $(this).data('lawid');
        $('#articleLawId').remove(); // إزالة أي hidden input موجود
        $('#addArticleForm').append(`<input type="hidden" id="articleLawId" value="${lawId}">`);
        $('#addArticleModal').modal('show');
    });

});

</script>