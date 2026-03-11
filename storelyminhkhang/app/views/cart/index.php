<nav aria-label="breadcrumb" class="mb-4 mt-2">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/storelyminhkhang" class="text-decoration-none" style="color: #d70018;"><i class="fa-solid fa-house"></i> Trang chủ</a></li>
        <li class="breadcrumb-item active" aria-current="page">Giỏ hàng của bạn</li>
    </ol>
</nav>

<h3 class="fw-bold mb-4 text-dark"><i class="fa-solid fa-cart-shopping me-2" style="color: #d70018;"></i>GIỎ HÀNG</h3>

<?php if(empty($cart)): ?>
    <div class="card shadow-sm border-0 text-center py-5 rounded-4">
        <div class="card-body">
            <h5 class="text-muted mb-4">Giỏ hàng của bạn đang trống!</h5>
            <a href="/storelyminhkhang" class="btn btn-lg text-white rounded-pill px-5 shadow-sm" style="background-color: #d70018;">Tiếp tục mua sắm</a>
        </div>
    </div>
<?php else: ?>
    <div class="row mb-5">
        <div class="col-lg-8 mb-4 mb-lg-0">
            <form action="/storelyminhkhang/cart/update" method="POST">
                <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle mb-0">
                            <thead class="bg-light text-muted">
                                <tr>
                                    <th scope="col" class="ps-4">Sản phẩm</th>
                                    <th scope="col">Đơn giá</th>
                                    <th scope="col" width="120">Số lượng</th>
                                    <th scope="col" class="text-end pe-4">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $totalPrice = 0;
                                foreach($cart as $item): 
                                    $subTotal = $item['price'] * $item['quantity'];
                                    $totalPrice += $subTotal;
                                ?>
                                    <tr class="border-bottom">
                                        <td class="ps-4 py-3">
                                            <div class="d-flex align-items-center">
                                                <img src="<?= !empty($item['image']) ? $item['image'] : 'https://via.placeholder.com/80' ?>" alt="..." class="rounded-3" style="width: 70px; height: 70px; object-fit: cover;">
                                                <div class="ms-3">
                                                    <h6 class="mb-1 text-dark fw-bold"><?= htmlspecialchars($item['name']) ?></h6>
                                                    <a href="/storelyminhkhang/cart/remove/<?= $item['id'] ?>" class="text-danger small text-decoration-none"><i class="fa-solid fa-trash me-1"></i> Xóa</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="fw-medium"><?= number_format($item['price'], 0, ',', '.') ?> ₫</td>
                                        <td>
                                            <input type="number" name="qty[<?= $item['id'] ?>]" value="<?= $item['quantity'] ?>" min="1" class="form-control text-center">
                                        </td>
                                        <td class="text-end pe-4 fw-bold" style="color: #d70018;">
                                            <?= number_format($subTotal, 0, ',', '.') ?> ₫
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer bg-white border-0 py-3 ps-4">
                        <button type="submit" class="btn btn-outline-secondary rounded-pill btn-sm"><i class="fa-solid fa-rotate-right me-1"></i> Cập nhật giỏ hàng</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-lg-4">
            
            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3"><i class="fa-solid fa-ticket me-2" style="color: #d70018;"></i>Mã giảm giá (Voucher)</h6>
                    
                    <form method="POST" action="/storelyminhkhang/cart">
                        <div class="input-group">
                            <input type="text" name="voucher_code" class="form-control" placeholder="Nhập mã (VD: LJRUI10)" value="<?= $_SESSION['voucher']['code'] ?? '' ?>">
                            <button name="apply_voucher" class="btn btn-dark px-3" type="submit">Áp dụng</button>
                        </div>
                    </form>

                    <?php if(isset($error_voucher) && !empty($error_voucher)): ?>
                        <div class="text-danger small mt-2 fw-bold"><i class="fa-solid fa-circle-exclamation me-1"></i> <?= $error_voucher ?></div>
                    <?php endif; ?>
                    <?php if(isset($success_voucher) && !empty($success_voucher)): ?>
                        <div class="text-success small mt-2 fw-bold"><i class="fa-solid fa-circle-check me-1"></i> <?= $success_voucher ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Tóm tắt đơn hàng</h5>
                    
                    <?php 
                        // Tính toán số tiền giảm giá nếu có Voucher
                        $discountAmount = 0;
                        if(isset($_SESSION['voucher'])) {
                            $percent = $_SESSION['voucher']['discount_percent'];
                            $discountAmount = ($totalPrice * $percent) / 100;
                        }
                        $finalTotal = $totalPrice - $discountAmount;
                    ?>

                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Tạm tính:</span>
                        <span class="fw-medium"><?= number_format($totalPrice, 0, ',', '.') ?> ₫</span>
                    </div>

                    <?php if($discountAmount > 0): ?>
                        <div class="d-flex justify-content-between mb-3 text-danger">
                            <span>Giảm giá (<?= $_SESSION['voucher']['discount_percent'] ?>%):</span>
                            <span>- <?= number_format($discountAmount, 0, ',', '.') ?> ₫</span>
                        </div>
                    <?php endif; ?>

                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Phí vận chuyển:</span>
                        <span class="text-success fw-medium">Miễn phí</span>
                    </div>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between mb-4">
                        <span class="fw-bold fs-5">Tổng cộng:</span>
                        <span class="fw-bold fs-4" style="color: #d70018;">
                            <?= number_format($finalTotal, 0, ',', '.') ?> ₫
                        </span>
                    </div>

                    <a href="/storelyminhkhang/cart/checkout" class="btn btn-lg w-100 text-white rounded-pill fw-bold shadow-sm" style="background-color: #d70018;">
                        TIẾN HÀNH THANH TOÁN
                    </a>
                    
                    <div class="text-center mt-3">
                        <small class="text-muted fst-italic">Áp dụng cho đơn hàng từ 300.000đ</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>