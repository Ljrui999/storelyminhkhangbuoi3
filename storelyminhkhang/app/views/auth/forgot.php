<div class="row justify-content-center mt-5 mb-5">
    <div class="col-md-5">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header text-white text-center py-3" style="background-color: #d70018;">
                <h4 class="mb-0 fw-bold"><i class="fa-solid fa-key me-2"></i>Khôi phục mật khẩu</h4>
            </div>
            <div class="card-body p-4 p-md-5">
                
                <?php if(!empty($error)): ?>
                    <div class="alert alert-danger"><i class="fa-solid fa-triangle-exclamation me-2"></i><?= $error ?></div>
                <?php endif; ?>
                
                <?php if(!empty($success)): ?>
                    <div class="alert alert-success fw-bold text-center"><i class="fa-solid fa-check me-2"></i><?= $success ?>
                        <a href="/storelyminhkhang/auth/login" class="btn btn-outline-success mt-3 w-100 rounded-pill">Về trang Đăng nhập</a>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center mb-4">Vui lòng nhập địa chỉ email bạn đã dùng để đăng ký. Hệ thống sẽ gửi một mật khẩu mới vào email của bạn.</p>
                    
                    <form method="POST" action="/storelyminhkhang/auth/forgot">
                        <div class="mb-4">
                            <label class="form-label fw-bold">Địa chỉ Email</label>
                            <input type="email" name="email" class="form-control form-control-lg bg-light" placeholder="Ví dụ: lyminhkhang45@gmail.com" required>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn text-white btn-lg fw-bold rounded-pill shadow-sm" style="background-color: #d70018;">
                                LẤY LẠI MẬT KHẨU
                            </button>
                        </div>
                    </form>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>