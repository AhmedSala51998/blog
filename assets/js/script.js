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
