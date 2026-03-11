<div class="row justify-content-center mt-5 mb-5">
    <div class="col-md-5">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-5">
                <h3 class="text-center fw-bold mb-4" style="color: #d70018;">ĐĂNG KÝ TÀI KHOẢN</h3>
                
                <?php if(!empty($error)): ?>
                    <div class="alert alert-danger text-center"><?= $error ?></div>
                <?php endif; ?>

                <?php if(!empty($success)): ?>
                    <div class="alert alert-success text-center">
                        <?= $success ?> <br>
                        <a href="/storelyminhkhang/auth/login" class="fw-bold text-success text-decoration-underline">Bấm vào đây để Đăng nhập</a>
                    </div>
                <?php else: ?>
                    <form method="POST" action="/storelyminhkhang/auth/register">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tên tài khoản</label>
                            <input type="text" name="username" class="form-control form-control-lg bg-light" placeholder="Viết liền không dấu..." required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Địa chỉ Email</label>
                            <input type="email" name="email" class="form-control form-control-lg bg-light" placeholder="Nhập email để khôi phục mật khẩu" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Mật khẩu</label>
                            <input type="password" name="password" class="form-control form-control-lg bg-light" placeholder="Nhập mật khẩu..." required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Nhập lại mật khẩu</label>
                            <input type="password" name="re_password" class="form-control form-control-lg bg-light" placeholder="Xác nhận lại mật khẩu..." required>
                        </div>
                        <button type="submit" class="btn text-white btn-lg w-100 rounded-pill fw-bold" style="background-color: #d70018;">ĐĂNG KÝ NGAY</button>
                    </form>
                    <div class="text-center mt-3">
                        <span class="text-muted">Đã có tài khoản? </span>
                        <a href="/storelyminhkhang/auth/login" class="text-decoration-none fw-bold" style="color: #d70018;">Đăng nhập</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>