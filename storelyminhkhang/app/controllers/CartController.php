<?php
require_once 'app/models/ProductModel.php';

// --- PHẦN MỚI: Khai báo sử dụng thư viện PHPMailer ---
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class CartController {
    private $productModel;

    public function __construct() {
        // --- CHẶN BẢO MẬT: CHƯA ĐĂNG NHẬP THÌ KHÔNG CHO DÙNG GIỎ HÀNG ---
        if (!isset($_SESSION['user'])) {
            $_SESSION['error_msg'] = "Bạn cần đăng nhập tài khoản để tiếp tục mua sắm!";
            header("Location: /storelyminhkhang/auth/login");
            exit();
        }

        $this->productModel = new ProductModel();
        // Khởi tạo giỏ hàng rỗng nếu chưa có
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    // 1. Hiển thị trang giỏ hàng
    public function index() {
        $error_voucher = '';
        $success_voucher = '';
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['apply_voucher'])) {
            require_once 'app/models/VoucherModel.php';
            $voucherModel = new VoucherModel();
            $code = trim($_POST['voucher_code']);
            $voucher = $voucherModel->checkVoucher($code);

            if ($voucher) {
                $_SESSION['voucher'] = $voucher; 
                $success_voucher = "Đã áp dụng mã giảm giá " . $voucher['discount_percent'] . "%";
            } else {
                unset($_SESSION['voucher']);
                $error_voucher = "Mã giảm giá không hợp lệ hoặc đã hết hạn!";
            }
        }

        require_once 'app/views/shares/header.php';
        require_once 'app/views/cart/index.php'; 
        require_once 'app/views/shares/footer.php';
    }

    // 2. Thêm sản phẩm vào giỏ
    public function add() {
        $url = isset($_GET['url']) ? explode('/', rtrim($_GET['url'], '/')) : [];
        $id = isset($url[2]) ? $url[2] : null;

        if ($id) {
            $product = $this->productModel->getProductById($id);
            if ($product) {
                $discount = isset($product['discount']) ? $product['discount'] : 0;
                $final_price = $product['price'] - ($product['price'] * $discount / 100);

                if (isset($_SESSION['cart'][$id])) {
                    $_SESSION['cart'][$id]['quantity'] += 1;
                } else {
                    $_SESSION['cart'][$id] = [
                        'id' => $product['id'],
                        'name' => $product['name'],
                        'price' => $final_price,
                        'image' => $product['image'],
                        'quantity' => 1
                    ];
                }
            }
        }
        header("Location: /storelyminhkhang/cart");
        exit();
    }

    // 3. Cập nhật số lượng
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['qty'])) {
            foreach ($_POST['qty'] as $id => $quantity) {
                if ($quantity <= 0) {
                    unset($_SESSION['cart'][$id]); 
                } elseif (isset($_SESSION['cart'][$id])) {
                    $_SESSION['cart'][$id]['quantity'] = $quantity; 
                }
            }
        }
        header("Location: /storelyminhkhang/cart");
        exit();
    }

    // 4. Xóa 1 sản phẩm
    public function remove() {
        $url = isset($_GET['url']) ? explode('/', rtrim($_GET['url'], '/')) : [];
        $id = isset($url[2]) ? $url[2] : null;

        if ($id && isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
        header("Location: /storelyminhkhang/cart");
        exit();
    }

    // 5. Thanh toán (Đã bổ sung phương thức thanh toán và gửi Email)
    public function checkout() {
        if (empty($_SESSION['cart'])) {
            header("Location: /storelyminhkhang");
            exit();
        }

        $error = '';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            require_once 'app/models/OrderModel.php';
            $orderModel = new OrderModel();

            $fullname = trim($_POST['fullname']);
            $phone = trim($_POST['phone']);
            $address = trim($_POST['address']);
            $payment_method = $_POST['payment_method']; // LẤY PHƯƠNG THỨC THANH TOÁN
            $user_id = isset($_SESSION['user']) ? $_SESSION['user']['id'] : null;
            $email_khach = isset($_SESSION['user']) ? $_SESSION['user']['email'] : '';

            $total_money = 0;
            foreach ($_SESSION['cart'] as $item) {
                $total_money += $item['price'] * $item['quantity'];
            }

            if (isset($_SESSION['voucher'])) {
                $discount = ($total_money * $_SESSION['voucher']['discount_percent']) / 100;
                $total_money = $total_money - $discount;
            }

            // Gọi hàm tạo đơn hàng (Nhớ cập nhật OrderModel thêm cột payment_method)
            $order_id = $orderModel->createOrder($user_id, $fullname, $phone, $address, $total_money, $payment_method, $_SESSION['cart']);

            if ($order_id) {
                
                // --- PHẦN GỬI EMAIL XÁC NHẬN ĐƠN HÀNG ---
                if (!empty($email_khach)) {
                    require 'app/libs/PHPMailer/Exception.php';
                    require 'app/libs/PHPMailer/PHPMailer.php';
                    require 'app/libs/PHPMailer/SMTP.php';

                    $mail = new PHPMailer(true);
                    try {
                        $mail->isSMTP();
                        $mail->Host       = 'smtp.gmail.com';
                        $mail->SMTPAuth   = true;
                        $mail->Username   = 'lyminhkhang45@gmail.com';
                        $mail->Password   = 'jbof sogn ihyr vpir'; // THAY BẰNG MÃ 16 KÝ TỰ CỦA BẠN
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                        $mail->Port       = 465;
                        $mail->CharSet    = 'UTF-8';

                        $mail->setFrom('lyminhkhang45@gmail.com', 'LJRUI Store - Xác nhận đơn hàng');
                        $mail->addAddress($email_khach, $fullname);

                        $mail->isHTML(true);
                        $mail->Subject = "Đơn hàng #$order_id của bạn đã được tiếp nhận!";
                        
                        // Nội dung Email dạng bảng hóa đơn
                        $htmlBody = "<h3>Cảm ơn $fullname đã tin tưởng mua sắm tại LJRUI Store!</h3>";
                        $htmlBody .= "<p>Mã đơn hàng: <b>#$order_id</b></p>";
                        $htmlBody .= "<p>Hình thức thanh toán: <b>" . strtoupper($payment_method) . "</b></p>";
                        $htmlBody .= "<table border='1' cellspacing='0' cellpadding='8' style='width:100%; border-collapse:collapse; border-color:#eee;'>
                                        <tr style='background:#f9f9f9;'><th>Sản phẩm</th><th>SL</th><th>Thành tiền</th></tr>";
                        foreach ($_SESSION['cart'] as $item) {
                            $htmlBody .= "<tr><td>{$item['name']}</td><td>{$item['quantity']}</td><td>" . number_format($item['price']) . "đ</td></tr>";
                        }
                        $htmlBody .= "</table>";
                        $htmlBody .= "<h4>Tổng cộng: <span style='color:red;'>" . number_format($total_money) . " VNĐ</span></h4>";
                        $htmlBody .= "<p>Địa chỉ nhận hàng: <i>$address</i></p>";
                        $htmlBody .= "<br><p>Chúng tôi sẽ sớm liên hệ xác nhận và giao hàng cho bạn!</p>";

                        $mail->Body = $htmlBody;
                        $mail->send();
                    } catch (Exception $e) {
                        // Bỏ qua nếu lỗi mail, đơn hàng vẫn đã lưu thành công
                    }
                }

                unset($_SESSION['cart']);
                unset($_SESSION['voucher']); 
                
                require_once 'app/views/shares/header.php';
                echo "<div class='container mt-5 text-center mb-5'>
                        <div class='card border-0 shadow-lg p-5 rounded-4'>
                            <h2 class='text-success fw-bold'><i class='fa-solid fa-circle-check mb-3 d-block' style='font-size: 5rem;'></i>ĐẶT HÀNG THÀNH CÔNG!</h2>
                            <p class='fs-5 mt-3'>Cảm ơn bạn đã lựa chọn <b>LJRUI Store</b>.</p>
                            <p>Một email xác nhận đã được gửi đến: <b>$email_khach</b></p>
                            <p class='text-muted small'>Mã đơn hàng: #$order_id</p>
                            <a href='/storelyminhkhang' class='btn btn-lg text-white mt-4 rounded-pill px-5 shadow-sm' style='background-color: #d70018;'>Tiếp tục mua sắm</a>
                        </div>
                      </div>";
                require_once 'app/views/shares/footer.php';
                exit();
            } else {
                $error = "Có lỗi xảy ra trong quá trình đặt hàng. Vui lòng thử lại!";
            }
        }

        require_once 'app/views/shares/header.php';
        require_once 'app/views/cart/checkout.php';
        require_once 'app/views/shares/footer.php';
    }
}
?>