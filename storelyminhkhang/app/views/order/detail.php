<div class="mb-4 mt-2 d-flex justify-content-between align-items-center">
    <h3 class="fw-bold mb-0"><i class="fa-solid fa-circle-info me-2 text-primary"></i>Chi tiết Đơn hàng #<?= $orderInfo['id'] ?></h3>
    <a href="/storelyminhkhang/order" class="btn btn-outline-secondary rounded-pill"><i class="fa-solid fa-arrow-left me-1"></i> Quay lại</a>
</div>

<div class="row mb-5">
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm border-0 rounded-4 h-100">
            <div class="card-header bg-primary text-white text-center fw-bold py-3">
                THÔNG TIN NGƯỜI NHẬN
            </div>
            <div class="card-body p-4">
                <p class="mb-2"><i class="fa-solid fa-user text-muted me-2"></i> <b>Họ tên:</b> <?= htmlspecialchars($orderInfo['fullname']) ?></p>
                <p class="mb-2"><i class="fa-solid fa-phone text-muted me-2"></i> <b>SĐT:</b> <?= htmlspecialchars($orderInfo['phone']) ?></p>
                <p class="mb-2"><i class="fa-solid fa-location-dot text-muted me-2"></i> <b>Địa chỉ:</b> <?= htmlspecialchars($orderInfo['address']) ?></p>
                <hr>
                <p class="mb-0"><i class="fa-solid fa-calendar-days text-muted me-2"></i> <b>Ngày đặt:</b> <span class="text-primary"><?= date('d/m/Y H:i', strtotime($orderInfo['created_at'])) ?></span></p>
            </div>
        </div>
    </div>

    <div class="col-md-8 mb-4">
        <div class="card shadow-sm border-0 rounded-4 h-100 overflow-hidden">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Sản phẩm</th>
                            <th>Đơn giá</th>
                            <th class="text-center">Số lượng</th>
                            <th class="text-end pe-4">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($orderDetails as $item): ?>
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <img src="<?= !empty($item['image']) ? $item['image'] : 'https://via.placeholder.com/50' ?>" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                        <span class="ms-3 fw-medium"><?= htmlspecialchars($item['product_name']) ?></span>
                                    </div>
                                </td>
                                <td><?= number_format($item['price'], 0, ',', '.') ?> ₫</td>
                                <td class="text-center fw-bold text-primary">x<?= $item['quantity'] ?></td>
                                <td class="text-end pe-4 fw-bold text-danger">
                                    <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?> ₫
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <tr class="bg-light">
                            <td colspan="3" class="text-end fw-bold pt-3 fs-5">TỔNG CỘNG:</td>
                            <td class="text-end pe-4 fw-bold fs-4 text-danger pt-3">
                                <?= number_format($orderInfo['total_money'], 0, ',', '.') ?> ₫
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>