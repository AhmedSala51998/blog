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
