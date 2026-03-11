<?php
require_once 'app/models/OrderModel.php';

class OrderController {
    private $orderModel;

    public function __construct() {
        $this->orderModel = new OrderModel();
    }

    // 1. Hiển thị danh sách tất cả đơn hàng
    public function index() {
        // --- CHẶN BẢO MẬT: CHỈ ADMIN MỚI ĐƯỢC VÀO ---
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header("Location: /storelyminhkhang");
            exit();
        }

        $orders = $this->orderModel->getAllOrders();

        require_once 'app/views/shares/header.php';
        require_once 'app/views/order/index.php'; // Ta sẽ tạo file này
        require_once 'app/views/shares/footer.php';
    }

    // 2. Hiển thị chi tiết 1 đơn hàng
    public function detail() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header("Location: /storelyminhkhang");
            exit();
        }

        $url = isset($_GET['url']) ? explode('/', rtrim($_GET['url'], '/')) : [];
        $id = isset($url[2]) ? $url[2] : null;

        if (!$id) {
            echo "<h2 class='text-center mt-5'>Lỗi: Không tìm thấy mã đơn hàng!</h2>";
            return;
        }

        $orderInfo = $this->orderModel->getOrderById($id);
        $orderDetails = $this->orderModel->getOrderDetails($id);

        require_once 'app/views/shares/header.php';
        require_once 'app/views/order/detail.php'; // Ta sẽ tạo file này
        require_once 'app/views/shares/footer.php';
    }
}
?>