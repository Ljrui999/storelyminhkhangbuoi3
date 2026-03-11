<div class="row justify-content-center mt-4 mb-5">
    <div class="col-md-10">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header text-white text-center py-3" style="background-color: #d70018;">
                <h4 class="mb-0 fw-bold"><i class="fa-solid fa-images me-2"></i>Quản lý Slider Quảng cáo</h4>
            </div>
            <div class="card-body p-4 p-md-5">
                <?php if(!empty($success)): ?>
                    <div class="alert alert-success fw-bold text-center"><i class="fa-solid fa-check me-2"></i><?= $success ?></div>
                <?php endif; ?>

                <form method="POST" action="/storelyminhkhang/banner" class="mb-5">
                    <div class="input-group input-group-lg">
                        <input type="url" name="image_url" class="form-control bg-light" placeholder="Dán link ảnh ngang (VD: https://.../banner.jpg)" required>
                        <button type="submit" class="btn text-white fw-bold px-4" style="background-color: #d70018;">THÊM MỚI</button>
                    </div>
                </form>

                <hr>
                
                <h6 class="fw-bold text-secondary mb-4 mt-4">Các Banner đang hiển thị trên trang chủ:</h6>
                
                <div class="row row-cols-1 row-cols-md-2 g-4">
                    <?php if(!empty($banners)): ?>
                        <?php foreach($banners as $b): ?>
                            <div class="col">
                                <div class="card h-100 shadow-sm border text-center">
                                    <img src="<?= htmlspecialchars($b['image_url']) ?>" class="card-img-top" style="height: 150px; object-fit: cover;">
                                    <div class="card-body p-2">
                                        <a href="/storelyminhkhang/banner/delete/<?= $b['id'] ?>" class="btn btn-sm btn-outline-danger w-100" onclick="return confirm('Bạn có chắc muốn xóa ảnh này khỏi trang chủ?');">
                                            <i class="fa-solid fa-trash me-1"></i> Xóa ảnh này
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12 text-center text-muted fst-italic">Chưa có banner nào. Hãy thêm ảnh để trang chủ đẹp hơn!</div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
</div>