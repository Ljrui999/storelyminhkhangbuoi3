<div class="row justify-content-center mt-4 mb-5">
    <div class="col-md-8">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header text-white text-center py-3" style="background-color: #d70018;">
                <h4 class="mb-0 fw-bold"><i class="fa-solid fa-truck-fast me-2"></i>Thông tin giao hàng & Thanh toán</h4>
            </div>
            <div class="card-body p-4 p-md-5">
                
                <?php if(!empty($error)): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>

                <div class="alert alert-info text-center mb-4 rounded-3 border-0 shadow-sm" style="background-color: #f0f7ff;">
                    <?php 
                        $total = 0;
                        foreach($_SESSION['cart'] as $item) {
                            $total += $item['price'] * $item['quantity'];
                        }
                        
                        // Trừ tiền Voucher nếu khách đã nhập ở bước trước
                        $discount = 0;
                        if(isset($_SESSION['voucher'])) {
                            $discount = ($total * $_SESSION['voucher']['discount_percent']) / 100;
                        }
                        $final_total = $total - $discount;
                    ?>
                    <p class="text-muted mb-1 small text-uppercase fw-bold">Tổng thanh toán sau cùng</p>
                    <h5 class="mb-0"><span class="fw-bold text-danger fs-3"><?= number_format($final_total, 0, ',', '.') ?> VNĐ</span></h5>
                    <?php if($discount > 0): ?>
                        <small class="text-success fw-bold">(Đã giảm <?= $_SESSION['voucher']['discount_percent'] ?>% từ Voucher)</small>
                    <?php endif; ?>
                </div>

                <form method="POST" action="/storelyminhkhang/cart/checkout">
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3 text-secondary border-bottom pb-2">1. THÔNG TIN NGƯỜI NHẬN</h6>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Họ và tên</label>
                            <input type="text" name="fullname" class="form-control form-control-lg bg-light" placeholder="Nhập họ và tên..." value="<?= isset($_SESSION['user']) ? htmlspecialchars($_SESSION['user']['username']) : '' ?>" required>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Số điện thoại</label>
                                <input type="text" name="phone" class="form-control form-control-lg bg-light" placeholder="Nhập số điện thoại liên hệ..." required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Địa chỉ nhận hàng chi tiết</label>
                            <textarea name="address" class="form-control bg-light" rows="3" placeholder="Số nhà, Tên đường, Phường/Xã, Quận/Huyện, Tỉnh/Thành phố..." required></textarea>
                        </div>
                    </div>

                    <div class="mb-5">
                        <h6 class="fw-bold mb-3 text-secondary border-bottom pb-2">2. CHỌN HÌNH THỨC THANH TOÁN</h6>
                        
                        <div class="form-check p-3 border rounded-3 mb-2 shadow-sm payment-item">
                            <input class="form-check-input ms-0 me-3" type="radio" name="payment_method" id="cod" value="cod" checked>
                            <label class="form-check-label fw-bold w-100 cursor-pointer" for="cod">
                                <i class="fa-solid fa-money-bill-1-wave me-2 text-success"></i>Thanh toán khi nhận hàng (COD)
                            </label>
                        </div>

                        <div class="form-check p-3 border rounded-3 mb-2 shadow-sm payment-item">
                            <input class="form-check-input ms-0 me-3" type="radio" name="payment_method" id="bank" value="bank">
                            <label class="form-check-label fw-bold w-100 cursor-pointer" for="bank">
                                <i class="fa-solid fa-building-columns me-2 text-primary"></i>Chuyển khoản Ngân hàng
                            </label>
                            <div id="bank_info" class="mt-3 p-3 rounded-3 bg-white border d-none">
                                <p class="mb-1 fw-bold text-dark"><i class="fa-solid fa-info-circle me-1"></i> Thông tin tài khoản:</p>
                                <p class="mb-1 ms-3 small text-muted">Ngân hàng: <b>VietinBank</b></p>
                                <p class="mb-1 ms-3 small text-muted">Số tài khoản: <b>123456789</b></p>
                                <p class="mb-0 ms-3 small text-muted">Chủ TK: <b>LÝ MINH KHANG</b></p>
                                <p class="mt-2 mb-0 small text-danger fst-italic">* Vui lòng chụp màn hình sau khi chuyển khoản thành công.</p>
                            </div>
                        </div>

                        <div class="form-check p-3 border rounded-3 mb-2 shadow-sm payment-item">
                            <input class="form-check-input ms-0 me-3" type="radio" name="payment_method" id="momo" value="momo">
                            <label class="form-check-label fw-bold w-100 cursor-pointer" for="momo">
                                <img src="https://www.bing.com/th/id/OIP.-DhgkiQDEdoru7CJdZrwEAHaHa?w=205&h=211&c=8&rs=1&qlt=90&o=6&pid=3.1&rm=2" width="22" class="me-2 rounded shadow-sm" style="background: #ae1e6e;">Thanh toán qua Ví MoMo
                            </label>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn text-white btn-lg fw-bold rounded-pill shadow-sm py-3 mb-2" style="background-color: #d70018;">
                            XÁC NHẬN ĐẶT HÀNG
                        </button>
                        <a href="/storelyminhkhang/cart" class="btn btn-light btn-lg rounded-pill border fw-medium">Quay lại giỏ hàng</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<style>
    .payment-item { transition: all 0.2s ease-in-out; border-color: #eee !important; }
    .payment-item:hover { background-color: #fdfdfd; border-color: #d70018 !important; }
    .cursor-pointer { cursor: pointer; }
    input[type='radio']:checked + label { color: #d70018; }
</style>

<script>
    // Script xử lý ẩn hiện thông tin ngân hàng
    document.querySelectorAll('input[name="payment_method"]').forEach(input => {
        input.addEventListener('change', function() {
            const bankBox = document.getElementById('bank_info');
            if (this.id === 'bank') {
                bankBox.classList.remove('d-none');
            } else {
                bankBox.classList.add('d-none');
            }
        });
    });
</script>