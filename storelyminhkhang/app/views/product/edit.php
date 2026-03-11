<div class="row justify-content-center mb-5 mt-4">
    <div class="col-md-8">
        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
            <div class="card-header text-white text-center py-3" style="background-color: #0d6efd;">
                <h4 class="mb-0 fw-bold"><i class="fa-solid fa-pen-to-square me-2"></i>Cập nhật sản phẩm</h4>
            </div>
            <div class="card-body p-4 p-md-5 bg-white">
                <form method="POST" action="/storelyminhkhang/product/edit/<?= $product['id'] ?>">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary">Tên sản phẩm</label>
                        <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" class="form-control form-control-lg bg-light" required>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-secondary">Danh mục</label>
                            <select name="category_id" class="form-select form-select-lg bg-light" required>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>" <?= ($cat['id'] == $product['category_id']) ? 'selected' : '' ?>>
                                        <?= $cat['name'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-secondary">Giá bán (VNĐ)</label>
                            <input type="number" name="price" value="<?= $product['price'] ?>" class="form-control form-control-lg bg-light" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold text-secondary">Giảm giá (%)</label>
                            <input type="number" name="discount" value="<?= $product['discount'] ?? 0 ?>" class="form-control form-control-lg bg-light" min="0" max="100">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary">Link hình ảnh (URL)</label>
                        <input type="url" name="image" value="<?= htmlspecialchars($product['image'] ?? '') ?>" class="form-control form-control-lg bg-light" placeholder="Nhập đường dẫn ảnh mới nếu muốn thay đổi...">
                        
                        <?php if(!empty($product['image'])): ?>
                            <div class="mt-3 p-3 border rounded-3 d-inline-block bg-light shadow-sm">
                                <span class="d-block small text-muted mb-2 fw-bold">Ảnh hiện tại:</span>
                                <img src="<?= $product['image'] ?>" alt="Preview" style="height: 100px; object-fit: contain; border-radius: 6px;">
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-5">
                        <label class="form-label fw-bold text-secondary">Mô tả chi tiết</label>
                        <textarea name="description" class="form-control bg-light" rows="6"><?= htmlspecialchars($product['description'] ?? '') ?></textarea>
                    </div>

                    <hr class="mb-4 text-muted">

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        
                        <a href="/storelyminhkhang/product/delete/<?= $product['id'] ?>" class="btn btn-danger btn-lg px-4 rounded-pill shadow-sm fw-bold me-md-auto" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này? Thao tác này không thể hoàn tác!');">
                            <i class="fa-solid fa-trash-can me-2"></i>Xóa sản phẩm
                        </a>

                        <a href="/storelyminhkhang/product/list" class="btn btn-light btn-lg border px-4 rounded-pill fw-bold">Hủy bỏ</a>
                        <button type="submit" class="btn btn-primary text-white btn-lg px-5 rounded-pill shadow-sm fw-bold">Lưu cập nhật</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>