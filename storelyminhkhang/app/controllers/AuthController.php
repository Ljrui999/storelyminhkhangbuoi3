<?php
require_once 'app/models/UserModel.php';

// --- PHẦN MỚI: Khai báo sử dụng thư viện PHPMailer ---
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function login() {
        $error = '';
        if (isset($_SESSION['error_msg'])) {
            $error = $_SESSION['error_msg'];
            unset($_SESSION['error_msg']);
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = trim($_POST['username']);
            $password = $_POST['password'];
            $user = $this->userModel->login($username, $password);

            if ($user) {
                $_SESSION['user'] = $user;
                header("Location: /STORELYMINHKHANG"); 
                exit();
            } else {
                $error = "Sai tài khoản hoặc mật khẩu!";
            }
        }
        require_once 'app/views/shares/header.php';
        require_once 'app/views/auth/login.php';
        require_once 'app/views/shares/footer.php';
    }

    public function logout() {
        session_destroy();
        header("Location: /STORELYMINHKHANG");
        exit();
    }

    // --- CẬP NHẬT: Hàm Đăng ký có thêm Email ---
    public function register() {
        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = trim($_POST['username']);
            $email = trim($_POST['email']); // Lấy email từ form
            $password = $_POST['password'];
            $re_password = $_POST['re_password'];

            if ($password !== $re_password) {
                $error = "Mật khẩu nhập lại không khớp!";
            } elseif ($this->userModel->checkUserExists($username)) {
                $error = "Tài khoản này đã có người sử dụng!";
            } else {
                // Truyền thêm biến $email vào hàm register của Model
                if ($this->userModel->register($username, $password, $email)) {
                    $success = "Đăng ký thành công! Bạn có thể đăng nhập ngay.";
                } else {
                    $error = "Có lỗi xảy ra, vui lòng thử lại sau.";
                }
            }
        }
        require_once 'app/views/shares/header.php';
        require_once 'app/views/auth/register.php';
        require_once 'app/views/shares/footer.php';
    }

    // --- PHẦN MỚI: Hàm xử lý Quên mật khẩu ---
    public function forgot() {
        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = trim($_POST['email']);
            // Tìm xem email này có trong bảng user không
            $user = $this->userModel->getUserByEmail($email);

            if ($user) {
                // 1. Tạo mật khẩu ngẫu nhiên mới
                $newPassword = rand(100000, 999999);
                
                // 2. Cập nhật mật khẩu mới vào Database
                $this->userModel->updatePassword($user['id'], $newPassword);

                // 3. Gửi Email
                require 'app/libs/PHPMailer/Exception.php';
                require 'app/libs/PHPMailer/PHPMailer.php';
                require 'app/libs/PHPMailer/SMTP.php';

                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'lyminhkhang45@gmail.com'; 
                    // THAY MÃ 16 KÝ TỰ CỦA BẠN VÀO ĐÂY
                    $mail->Password   = 'jbof sogn ihyr vpir'; 
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                    $mail->Port       = 465;
                    $mail->CharSet    = 'UTF-8';

                    $mail->setFrom('lyminhkhang45@gmail.com', 'LJRUI Store Support');
                    $mail->addAddress($email, $user['username']); 

                    $mail->isHTML(true);
                    $mail->Subject = 'Khôi phục mật khẩu tài khoản LJRUI';
                    $mail->Body    = "<h3>Chào <b>{$user['username']}</b>,</h3>
                                      <p>Mật khẩu đăng nhập mới của bạn là: <b style='color:red; font-size: 20px;'>{$newPassword}</b></p>
                                      <p>Vui lòng đăng nhập và đổi lại mật khẩu để bảo mật.</p>";

                    $mail->send();
                    $success = "Mật khẩu mới đã được gửi vào Email của bạn!";
                } catch (Exception $e) {
                    $error = "Lỗi gửi mail: {$mail->ErrorInfo}";
                }
            } else {
                $error = "Email này không tồn tại trên hệ thống!";
            }
        }
        require_once 'app/views/shares/header.php';
        require_once 'app/views/auth/forgot.php';
        require_once 'app/views/shares/footer.php';
    }
}
?>