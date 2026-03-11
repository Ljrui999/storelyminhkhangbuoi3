<nav aria-label="breadcrumb" class="mb-4 mt-2">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/storelyminhkhang" class="text-decoration-none" style="color: #d70018;"><i class="fa-solid fa-house"></i> Trang chủ</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($product['name']) ?></li>
    </ol>
</nav>

<div class="card shadow border-0 rounded-4 overflow-hidden mb-5">
    <div class="row g-0">
        <div class="col-md-5 text-center p-4 d-flex align-items-center justify-content-center position-relative" style="background-color: #fff;">
            <?php if(isset($product['discount']) && $product['discount'] > 0): ?>
                <span class="badge bg-danger position-absolute top-0 start-0 m-4 shadow-lg fs-5" style="z-index: 2;">
                    Giảm <?= $product['discount'] ?>%
                </span>
            <?php endif; ?>
            
            <img src="<?= !empty($product['image']) ? $product['image'] : 'https://via.placeholder.com/500x500/ffffff/d70018?text=No+Image' ?>" 
                 class="img-fluid rounded" 
                 alt="<?= htmlspecialchars($product['name']) ?>"
                 style="max-height: 450px; object-fit: contain;">
        </div>

        <div class="col-md-7">
            <div class="card-body p-4 p-md-5 h-100 d-flex flex-column bg-light border-start">
                
                <h2 class="card-title fw-bold mb-3 text-dark"><?= htmlspecialchars($product['name']) ?></h2>
                <hr class="mt-0 mb-4">
                
                <div class="p-3 mb-4 rounded-3 shadow-sm position-relative" style="background-color: #fdf2f2; border: 1px solid #f9d3d3;">
                    <p class="mb-1 text-danger fw-bold small">Giá khuyến mãi đặc biệt:</p>
                    
                    <?php if(isset($product['discount']) && $product['discount'] > 0): ?>
                        <?php $new_price = $product['price'] - ($product['price'] * $product['discount'] / 100); ?>
                        <div class="d-flex align-items-baseline gap-3 mt-1">
                            <h2 class="fw-bold mb-0" style="color: #d70018;"><?= number_format($new_price, 0, ',', '.') ?> ₫</h2>
                            <h4 class="text-secondary text-decoration-line-through mb-0 fw-normal" style="opacity: 0.6;"><?= number_format($product['price'], 0, ',', '.') ?> ₫</h4>
                        </div>
                    <?php else: ?>
                        <h2 class="fw-bold mb-0" style="color: #d70018;"><?= number_format($product['price'], 0, ',', '.') ?> ₫</h2>
                    <?php endif; ?>
                </div>

                <div class="mb-4 flex-grow-1">
                    <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-star text-warning me-2"></i>Đặc điểm nổi bật</h5>
                    <div class="text-secondary bg-white p-3 rounded-3 border" style="white-space: pre-line; line-height: 1.8;">
                        <?= htmlspecialchars($product['description'] ?? 'Đang cập nhật mô tả cho sản phẩm này...') ?>
                    </div>
                </div>

                <div class="mt-auto d-flex flex-column flex-sm-row gap-2">
                    
                    <a href="/storelyminhkhang/cart/add/<?= $product['id'] ?>" class="btn text-white btn-lg flex-grow-1 rounded-3 fw-bold shadow-sm d-flex flex-column justify-content-center align-items-center text-decoration-none" style="background-color: #d70018;">
                        <span>THÊM VÀO GIỎ HÀNG</span>
                        <small class="fw-normal" style="font-size: 0.75rem;">(Giao tận nơi hoặc nhận tại cửa hàng)</small>
                    </a>
                    
                    <?php if(isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
                        <a href="/storelyminhkhang/product/edit/<?= $product['id'] ?>" class="btn btn-outline-primary btn-lg rounded-3 d-flex align-items-center justify-content-center px-4">
                            <i class="fa-solid fa-pen-to-square me-2"></i> Chỉnh Sửa
                        </a>
                    <?php endif; ?>

                </div>

            </div>
        </div>
    </div>
</div>