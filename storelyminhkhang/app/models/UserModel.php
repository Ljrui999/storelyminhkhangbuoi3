<?php
require_once 'app/config/database.php';

class UserModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // 1. Kiểm tra tài khoản tồn tại (Sửa thành bảng user)
    public function checkUserExists($username) {
        $query = "SELECT id FROM user WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    // 2. Đăng ký tài khoản mới
    public function register($username, $password, $email) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        // Gán cứng 'user' vào câu lệnh để tránh lỗi truncated
        $query = "INSERT INTO user (username, password, email, role) VALUES (:username, :password, :email, 'user')";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':email', $email);
        return $stmt->execute();
    }

    // 3. Đăng nhập (Sửa thành bảng user)
    public function login($username, $password) {
        $query = "SELECT * FROM user WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    // 4. Tìm user bằng Email (Phục vụ quên mật khẩu)
    public function getUserByEmail($email) {
        $query = "SELECT * FROM user WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 5. Cập nhật mật khẩu mới
    public function updatePassword($id, $new_password) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $query = "UPDATE user SET password = :password WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>