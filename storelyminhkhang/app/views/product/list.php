<div class="mb-3 py-1 shadow-sm" style="background-color: #fdf2f2; border: 1px dashed #d70018; border-radius: 6px;">
    <marquee behavior="scroll" direction="left" scrollamount="8" class="text-danger fw-bold mb-0" style="font-size: 0.85rem; padding-top: 2px;">
        <span class="mx-4"><i class="fa-solid fa-arrows-rotate me-1"></i>Thu cũ giá ngon - Lên đời tiết kiệm</span>
        <span class="mx-4 text-secondary">|</span>
        <span class="mx-4"><i class="fa-solid fa-shield-halved me-1"></i>Sản phẩm Chính hãng - Xuất VAT đầy đủ</span>
        <span class="mx-4 text-secondary">|</span>
        <span class="mx-4"><i class="fa-solid fa-truck-fast me-1"></i>Giao nhanh - Miễn phí cho đơn 300k</span>
        
        <span class="mx-4 text-secondary">|</span>
        <span class="mx-4"><i class="fa-solid fa-arrows-rotate me-1"></i>Thu cũ giá ngon - Lên đời tiết kiệm</span>
        <span class="mx-4 text-secondary">|</span>
        <span class="mx-4"><i class="fa-solid fa-shield-halved me-1"></i>Sản phẩm Chính hãng - Xuất VAT đầy đủ</span>
        <span class="mx-4 text-secondary">|</span>
        <span class="mx-4"><i class="fa-solid fa-truck-fast me-1"></i>Giao nhanh - Miễn phí cho đơn 300k</span>
    </marquee>
</div>
<?php if(isset($banners) && count($banners) > 0): ?>
    <div class="row mb-5 mt-2">
        <div class="col-12">
            <div id="bannerCarousel" class="carousel slide shadow-lg rounded-4 overflow-hidden" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php 
                    $isFirst = true;
                    foreach($banners as $b): 
                    ?>
                        <div class="carousel-item <?= $isFirst ? 'active' : '' ?>" data-bs-interval="3000">
                            <img src="<?= htmlspecialchars($b['image_url']) ?>" class="d-block w-100" style="height: 450px; object-fit: cover;" alt="Banner">
                        </div>
                    <?php 
                        $isFirst = false;
                    endforeach; 
                    ?>
                </div>
                
                <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true" style="background-color: rgba(0,0,0,0.3); border-radius: 50%; padding: 20px;"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true" style="background-color: rgba(0,0,0,0.3); border-radius: 50%; padding: 20px;"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if(!empty($flashSales)): ?>
<div class="card border-0 rounded-4 shadow mb-5" style="background: linear-gradient(135deg, #d70018, #ff4e50);">
    <div class="card-header border-0 bg-transparent pt-3 pb-2 d-flex justify-content-between align-items-center">
        <h3 class="fw-bold text-white mb-0" style="text-transform: uppercase; font-style: italic;">
            <i class="fa-solid fa-bolt text-warning me-2 fs-2"></i>Flash Sale Giá Sốc
        </h3>
        <span class="badge bg-warning text-dark rounded-pill px-3 py-2 fw-bold fs-6">Kết thúc sớm!</span>
    </div>
    <div class="card-body p-3 p-md-4">
        <div class="row row-cols-2 row-cols-md-4 g-3">
            <?php foreach ($flashSales as $row): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm border-0 rounded-3 product-card">
                        <div class="p-3 text-center position-relative">
                            <span class="badge bg-danger position-absolute top-0 start-0 m-2 shadow" style="font-size: 0.9rem; z-index: 2;">
                                Giảm <?= $row['discount'] ?>%
                            </span>
                            <img src="<?= !empty($row['image']) ? $row['image'] : 'https://via.placeholder.com/200' ?>" class="card-img-top rounded" style="object-fit: contain; height: 160px;">
                        </div>
                        <div class="card-body d-flex flex-column pt-0">
                            <h6 class="card-title fw-bold text-dark mb-1" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; font-size: 0.95rem;">
                                <?= htmlspecialchars($row['name']) ?>
                            </h6>
                            <div class="mt-auto pt-2">
                                <?php $new_price = $row['price'] - ($row['price'] * $row['discount'] / 100); ?>
                                <h5 class="fw-bold mb-0" style="color: #d70018;"><?= number_format($new_price, 0, ',', '.') ?> ₫</h5>
                                <small class="text-muted text-decoration-line-through"><?= number_format($row['price'], 0, ',', '.') ?> ₫</small>
                                
                                <a href="/storelyminhkhang/product/show/<?= $row['id'] ?>" class="btn w-100 rounded-pill mt-3 text-white fw-bold shadow-sm" style="background-color: #d70018;">Mua ngay</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-4 mt-2">
    <h3 class="fw-bold text-uppercase mb-0" style="color: #444;">Sản phẩm nổi bật</h3>
    
    <?php if(isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
        <a href="/storelyminhkhang/product/add" class="btn rounded-pill fw-bold shadow-sm text-white" style="background-color: #d70018;">
            <i class="fa-solid fa-plus me-1"></i> Thêm sản phẩm
        </a>
    <?php endif; ?>
</div>

<div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4 mb-5">
    <?php if (!empty($products)): ?>
        <?php foreach ($products as $row): ?>
            <div class="col">
                <div class="card h-100 shadow-sm border-0 rounded-3 product-card">
                    <div class="p-3 text-center position-relative">
                        <?php if(isset($row['discount']) && $row['discount'] > 0): ?>
                            <span class="badge bg-danger position-absolute top-0 start-0 m-2 shadow" style="font-size: 0.9rem; z-index: 2;">
                                Giảm <?= $row['discount'] ?>%
                            </span>
                        <?php endif; ?>
                        
                        <img src="<?= !empty($row['image']) ? $row['image'] : 'https://via.placeholder.com/200x200/ffffff/d70018?text=No+Image' ?>" 
                             class="card-img-top rounded" 
                             alt="<?= htmlspecialchars($row['name']) ?>" 
                             style="object-fit: contain; height: 180px;">
                    </div>
                    
                    <div class="card-body d-flex flex-column pt-0">
                        <h6 class="card-title fw-bold text-dark mb-1" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            <?= htmlspecialchars($row['name']) ?>
                        </h6>
                        <p class="text-muted small mb-2"><i class="fa-solid fa-tag me-1"></i> <?= htmlspecialchars($row['category_name']) ?></p>
                        
                        <div class="mt-auto">
                            <?php if(isset($row['discount']) && $row['discount'] > 0): ?>
                                <?php $new_price = $row['price'] - ($row['price'] * $row['discount'] / 100); ?>
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <h5 class="fw-bold mb-0" style="color: #d70018;"><?= number_format($new_price, 0, ',', '.') ?> ₫</h5>
                                    <small class="text-muted text-decoration-line-through"><?= number_format($row['price'], 0, ',', '.') ?> ₫</small>
                                </div>
                            <?php else: ?>
                                <h5 class="fw-bold mb-3" style="color: #d70018;"><?= number_format($row['price'], 0, ',', '.') ?> ₫</h5>
                            <?php endif; ?>
                            
                            <div class="d-flex justify-content-between gap-2 mt-2">
                                <a href="/storelyminhkhang/product/show/<?= $row['id'] ?>" class="btn btn-outline-secondary btn-sm w-100 rounded-pill">Chi tiết</a>
                                
                                <?php if(isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
                                    <a href="/storelyminhkhang/product/edit/<?= $row['id'] ?>" class="btn btn-outline-primary btn-sm w-100 rounded-pill">Sửa</a>
                                <?php else: ?>
                                    <a href="/storelyminhkhang/cart/add/<?= $row['id'] ?>" class="btn btn-sm w-100 rounded-pill text-white fw-bold shadow-sm" style="background-color: #d70018;">
                                        <i class="fa-solid fa-cart-plus"></i> Giỏ hàng
                                    </a>
                                <?php endif; ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12 text-center py-5">
            <h5 class="text-muted mt-3">Hiện chưa có sản phẩm nào trên kệ.</h5>
            <?php if(isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
                <a href="/storelyminhkhang/product/add" class="btn btn-outline-danger mt-2 rounded-pill">Thêm ngay</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>