<div class="row justify-content-center mb-5 mt-4">
    <div class="col-md-8">
        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
            <div class="card-header text-white text-center py-3" style="background-color: #d70018;">
                <h4 class="mb-0 fw-bold"><i class="fa-solid fa-box-open me-2"></i>Thêm sản phẩm mới</h4>
            </div>
            <div class="card-body p-4 p-md-5 bg-white">
                <form method="POST" action="/storelyminhkhang/product/add">
                    
                    <div class="mb-4 p-4 rounded-4 shadow-sm" style="background-color: #eef2ff; border: 2px dashed #4f46e5;">
                        <label class="form-label fw-bold" style="color: #4f46e5; font-size: 1.1rem;">
                            <i class="fa-solid fa-wand-magic-sparkles me-2"></i>Tự động điền từ Link (CellphoneS, TGDĐ...)
                        </label>
                        <div class="input-group input-group-lg mt-2">
                            <input type="url" id="auto_url" class="form-control bg-white" placeholder="Dán link sản phẩm (VD: https://cellphones.com.vn/...)">
                            <button type="button" class="btn text-white fw-bold px-4" style="background-color: #4f46e5;" id="btn_fetch" onclick="fetchData()">
                                <i class="fa-solid fa-cloud-arrow-down me-2"></i>LẤY DỮ LIỆU
                            </button>
                        </div>
                        <small class="mt-3 d-block fw-medium" id="fetch_status" style="color: #6366f1;">
                            Dán link và bấm nút để cào dữ liệu Tên, Ảnh, Mô tả tự động.
                        </small>
                    </div>

                    <script>
                    function fetchData() {
                        let url = document.getElementById('auto_url').value;
                        let statusObj = document.getElementById('fetch_status');
                        let btn = document.getElementById('btn_fetch');

                        if(!url) {
                            alert("Vui lòng dán link vào ô trước khi bấm!"); 
                            return;
                        }

                        // Hiển thị trạng thái đang tải
                        statusObj.innerHTML = "<span class='text-primary fw-bold'><i class='fa-solid fa-spinner fa-spin me-1'></i> Đang cào dữ liệu... Vui lòng đợi vài giây!</span>";
                        btn.disabled = true;

                        let formData = new FormData();
                        formData.append('url', url);

                        // Gửi dữ liệu ngầm lên ScraperController
                        fetch('/storelyminhkhang/scraper/fetch', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            btn.disabled = false;
                            if(data.success) {
                                statusObj.innerHTML = "<span class='text-success fw-bold'><i class='fa-solid fa-check me-1'></i> Đã lấy dữ liệu thành công! Hãy kiểm tra các ô bên dưới.</span>";
                                
                                // Bắn dữ liệu vào các ô input
                                if(data.data.name) document.querySelector('input[name="name"]').value = data.data.name;
                                if(data.data.image) document.querySelector('input[name="image"]').value = data.data.image;
                                if(data.data.description) document.querySelector('textarea[name="description"]').value = data.data.description;
                                if(data.data.price) document.querySelector('input[name="price"]').value = data.data.price;
                                
                            } else {
                                statusObj.innerHTML = "<span class='text-danger fw-bold'><i class='fa-solid fa-triangle-exclamation me-1'></i> " + data.message + "</span>";
                            }
                        })
                        .catch(err => {
                            btn.disabled = false;
                            statusObj.innerHTML = "<span class='text-danger fw-bold'><i class='fa-solid fa-triangle-exclamation me-1'></i> Bị lỗi kết nối mạng hoặc Tường lửa web đã chặn!</span>";
                        });
                    }
                    </script>
                    <hr class="mb-4 text-muted">

                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary">Tên sản phẩm</label>
                        <input type="text" name="name" class="form-control form-control-lg bg-light" placeholder="VD: iPhone 15 Pro Max 256GB" required>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-secondary">Danh mục</label>
                            <select name="category_id" class="form-select form-select-lg bg-light" required>
                                <option value="">-- Chọn danh mục --</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>"><?= $cat['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-secondary">Giá bán (VNĐ)</label>
                            <input type="number" name="price" class="form-control form-control-lg bg-light" placeholder="VD: 29990000" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold text-secondary">Giảm giá (%)</label>
                            <input type="number" name="discount" class="form-control form-control-lg bg-light" value="0" min="0" max="100">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary">Link hình ảnh (URL)</label>
                        <input type="url" name="image" class="form-control form-control-lg bg-light" placeholder="Nhập đường dẫn ảnh đuôi .jpg, .png... (Copy từ web khác)">
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-secondary">Mô tả chi tiết</label>
                        <textarea name="description" class="form-control bg-light" rows="5" placeholder="Nhập cấu hình, tính năng nổi bật..."></textarea>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <a href="/storelyminhkhang/product/list" class="btn btn-light btn-lg border px-4 rounded-pill fw-bold">Hủy bỏ</a>
                        <button type="submit" class="btn text-white btn-lg px-5 rounded-pill shadow-sm fw-bold" style="background-color: #d70018;">Lưu sản phẩm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>