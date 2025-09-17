<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">إضافة مدونة جديدة</h4>
                </div>
                <div class="card-body">
                    <form id="blogForm">
                        <div class="mb-3">
                            <label for="blogTitle" class="form-label">عنوان المدونة</label>
                            <input type="text" class="form-control" id="blogTitle" required>
                        </div>
                        <div class="mb-3">
                            <label for="blogCategory" class="form-label">تصنيف المدونة</label>
                            <select class="form-select" id="blogCategory" required>
                                <option value="" selected disabled>اختر تصنيف</option>
                                <option value="1">قانوني</option>
                                <option value="2">اجتماعي</option>
                                <option value="3">اقتصادي</option>
                                <option value="4">ثقافي</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="blogContent" class="form-label">محتوى المدونة</label>
                            <textarea class="form-control" id="blogContent" rows="10" required></textarea>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
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
                        </div>
                        <div class="mb-3">
                            <label for="systemSelect" class="form-label">الاستدلال من مكتب العمل</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <select class="form-select mb-2" id="systemSelect">
                                        <option value="" selected disabled>اختر نظام</option>
                                        <option value="1">نظام العمل</option>
                                        <option value="2">نظام الموارد البشرية</option>
                                        <option value="3">نظام التأمينات الاجتماعية</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select class="form-select mb-2" id="lawSelect" disabled>
                                        <option value="" selected disabled>اختر مادة</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select class="form-select mb-2" id="articleSelect" disabled>
                                        <option value="" selected disabled>اختر جزء</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="blogTags" class="form-label">الكلمات المفتاحية</label>
                            <input type="text" class="form-control" id="blogTags" placeholder="افصل بين الكلمات بفاصلة">
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="publishNow">
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
                                <tr>
                                    <td>مدونة عن نظام العمل</td>
                                    <td>قانوني</td>
                                    <td>2023-05-15</td>
                                    <td><span class="badge bg-success">منشور</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-info"><i class="fas fa-eye"></i></button>
                                        <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>مدونة عن التأمينات الاجتماعية</td>
                                    <td>اقتصادي</td>
                                    <td>2023-05-10</td>
                                    <td><span class="badge bg-warning">مسودة</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-info"><i class="fas fa-eye"></i></button>
                                        <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- نافذة معاينة المدونة -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="previewModalLabel">معاينة المدونة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="blog-preview">
                    <h3 id="previewTitle">عنوان المدونة</h3>
                    <div id="previewContent">
                        محتوى المدونة سيظهر هنا
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-primary" id="previewCategory">تصنيف</span>
                        <span class="badge bg-info" id="previewDate">التاريخ</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>
