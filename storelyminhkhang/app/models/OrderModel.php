<?php
require_once 'app/config/database.php';

class OrderModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // HÀM ĐÃ SỬA: Thêm tham số $payment_method và trả về $order_id
    public function createOrder($user_id, $fullname, $phone, $address, $total_money, $payment_method, $cart) {
        try {
            $this->conn->beginTransaction();

            // 1. Lưu vào bảng orders (Thêm cột payment_method)
            $queryOrder = "INSERT INTO orders (user_id, fullname, phone, address, total_money, payment_method) 
                           VALUES (:user_id, :fullname, :phone, :address, :total_money, :payment_method)";
            $stmt = $this->conn->prepare($queryOrder);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':fullname', $fullname);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':total_money', $total_money);
            $stmt->bindParam(':payment_method', $payment_method);
            $stmt->execute();

            $order_id = $this->conn->lastInsertId();

            // 2. Lưu từng sản phẩm vào bảng order_details
            $queryDetail = "INSERT INTO order_details (order_id, product_id, price, quantity) 
                            VALUES (:order_id, :product_id, :price, :quantity)";
            $stmtDetail = $this->conn->prepare($queryDetail);

            foreach ($cart as $item) {
                $stmtDetail->bindParam(':order_id', $order_id);
                $stmtDetail->bindParam(':product_id', $item['id']);
                $stmtDetail->bindParam(':price', $item['price']);
                $stmtDetail->bindParam(':quantity', $item['quantity']);
                $stmtDetail->execute();
            }

            $this->conn->commit();
            return $order_id; // TRẢ VỀ ID ĐỂ CONTROLLER GỬI MAIL
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    public function getAllOrders() {
        $query = "SELECT * FROM orders ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrderById($id) {
        $query = "SELECT * FROM orders WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getOrderDetails($order_id) {
        $query = "SELECT od.*, p.name as product_name, p.image 
                FROM order_details od 
                JOIN product p ON od.product_id = p.id 
                WHERE od.order_id = :order_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>