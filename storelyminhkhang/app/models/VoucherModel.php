<?php
require_once 'app/config/database.php';

class VoucherModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function checkVoucher($code) {
        $query = "SELECT * FROM vouchers 
                  WHERE code = :code 
                  AND status = 1 
                  AND expiry_date >= CURDATE() 
                  LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':code', $code);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>