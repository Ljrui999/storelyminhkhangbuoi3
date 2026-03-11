<?php
require_once 'app/config/database.php';

class BannerModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Lấy tất cả banner
    public function getAllBanners() {
        $query = "SELECT * FROM banners ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Admin thêm link banner mới
    public function addBanner($image_url) {
        $query = "INSERT INTO banners (image_url) VALUES (:image_url)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':image_url', $image_url);
        return $stmt->execute();
    }

    // Xóa banner
    public function deleteBanner($id) {
        $query = "DELETE FROM banners WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>