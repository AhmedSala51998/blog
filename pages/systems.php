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
                        <!-- سيتم عرض الأنظمة هنا -->
                        <div class="alert alert-info">
                            لا توجد أنظمة مضافة بعد. اضغط على "إضافة نظام جديد" للبدء.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- نافذة منبثقة لإضافة نظام جديد -->
<div class="modal fade" id="addSystemModal" tabindex="-1" aria-labelledby="addSystemModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSystemModalLabel">إضافة نظام جديد</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addSystemForm">
                    <div class="mb-3">
                        <label for="systemName" class="form-label">اسم النظام</label>
                        <input type="text" class="form-control" id="systemName" required>
                    </div>
                    <div class="mb-3">
                        <label for="systemDescription" class="form-label">وصف النظام</label>
                        <textarea class="form-control" id="systemDescription" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-primary" id="saveSystemBtn">حفظ النظام</button>
            </div>
        </div>
    </div>
</div>

<!-- نافذة منبثقة لإضافة مادة جديدة -->
<div class="modal fade" id="addLawModal" tabindex="-1" aria-labelledby="addLawModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addLawModalLabel">إضافة مادة جديدة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addLawForm">
                    <div class="mb-3">
                        <label for="lawName" class="form-label">اسم المادة</label>
                        <input type="text" class="form-control" id="lawName" required>
                    </div>
                    <div class="mb-3">
                        <label for="lawDescription" class="form-label">وصف المادة</label>
                        <textarea class="form-control" id="lawDescription" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-primary" id="saveLawBtn">حفظ المادة</button>
            </div>
        </div>
    </div>
</div>

<!-- نافذة منبثقة لإضافة جزء جديد -->
<div class="modal fade" id="addArticleModal" tabindex="-1" aria-labelledby="addArticleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addArticleModalLabel">إضافة جزء جديد</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addArticleForm">
                    <div class="mb-3">
                        <label for="articleNumber" class="form-label">رقم الجزء</label>
                        <input type="number" class="form-control" id="articleNumber" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label for="articleContent" class="form-label">نص الجزء</label>
                        <textarea class="form-control" id="articleContent" rows="5" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-primary" id="saveArticleBtn">حفظ الجزء</button>
            </div>
        </div>
    </div>
</div>
