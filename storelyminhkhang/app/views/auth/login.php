<div class="row justify-content-center mt-5 mb-5">
    <div class="col-md-5">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-5">
                <h3 class="text-center fw-bold mb-4" style="color: #d70018;">ĐĂNG NHẬP</h3>
                
                <?php if(!empty($error)): ?>
                    <div class="alert alert-danger text-center"><?= $error ?></div>
                <?php endif; ?>

                <form method="POST" action="/storelyminhkhang/auth/login">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tài khoản</label>
                        <input type="text" name="username" class="form-control form-control-lg bg-light" placeholder="Nhập tài khoản..." required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Mật khẩu</label>
                        <input type="password" name="password" class="form-control form-control-lg bg-light" placeholder="Nhập mật khẩu..." required>
                    </div>
                    <button type="submit" class="btn text-white btn-lg w-100 rounded-pill fw-bold" style="background-color: #d70018;">ĐĂNG NHẬP</button>
                    <a href="/storelyminhkhang/auth/forgot" class="d-block text-center mt-3 text-decoration-none" style="color: #4f46e5; font-weight: 500;">Bạn quên mật khẩu?</a>
                </form>
            </div>
        </div>
    </div>
</div>