<div class="d-flex justify-content-between align-items-center mb-4 mt-2">
    <h3 class="fw-bold text-uppercase mb-0"><i class="fa-solid fa-list-check me-2" style="color: #d70018;"></i>Quản lý Đơn Hàng</h3>
</div>

<div class="card shadow-sm border-0 rounded-4 overflow-hidden mb-5">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-dark text-white">
                <tr>
                    <th class="ps-4">Mã ĐH</th>
                    <th>Khách hàng</th>
                    <th>Số điện thoại</th>
                    <th>Ngày đặt</th>
                    <th class="text-end">Tổng tiền</th>
                    <th class="text-center pe-4">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($orders)): ?>
                    <?php foreach($orders as $order): ?>
                        <tr>
                            <td class="ps-4 fw-bold text-primary">#<?= $order['id'] ?></td>
                            <td class="fw-medium"><?= htmlspecialchars($order['fullname']) ?></td>
                            <td><?= htmlspecialchars($order['phone']) ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></td>
                            <td class="text-end fw-bold text-danger"><?= number_format($order['total_money'], 0, ',', '.') ?> ₫</td>
                            <td class="text-center pe-4">
                                <a href="/storelyminhkhang/order/detail/<?= $order['id'] ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">Xem chi tiết</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Chưa có đơn hàng nào trong hệ thống.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>