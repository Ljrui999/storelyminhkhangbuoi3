<?php
require_once 'app/config/database.php';

class ProductModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // 1. Lấy tất cả sản phẩm
    public function getAllProducts() {
        $query = "SELECT p.*, c.name as category_name 
                  FROM product p 
                  LEFT JOIN category c ON p.category_id = c.id
                  ORDER BY p.id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 2. Lấy 1 sản phẩm theo ID (Dùng cho trang Sửa)
    public function getProductById($id) {
        $query = "SELECT * FROM product WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 3. Thêm sản phẩm (Đã thêm discount)
    public function addProduct($name, $description, $price, $image, $category_id, $discount) {
        $query = "INSERT INTO product (name, description, price, image, category_id, discount) 
                  VALUES (:name, :description, :price, :image, :category_id, :discount)";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':discount', $discount);
        
        return $stmt->execute();
    }

    // 4. Cập nhật sản phẩm (Đã thêm discount)
    public function updateProduct($id, $name, $description, $price, $image, $category_id, $discount) {
        $query = "UPDATE product 
                  SET name = :name, description = :description, price = :price, image = :image, category_id = :category_id, discount = :discount 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':discount', $discount);
        
        return $stmt->execute();
    }
    // Hàm tìm kiếm sản phẩm theo tên
    public function searchProducts($keyword) {
        $query = "SELECT p.*, c.name as category_name 
                FROM product p 
                LEFT JOIN category c ON p.category_id = c.id
                WHERE p.name LIKE :keyword
                ORDER BY p.id DESC";
        $stmt = $this->conn->prepare($query);
        
        // Thêm dấu % để tìm kiếm các từ chứa keyword
        $keyword = "%{$keyword}%"; 
        $stmt->bindParam(':keyword', $keyword);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Lấy danh sách sản phẩm theo ID Danh mục
    public function getProductsByCategory($category_id) {
        $query = "SELECT p.*, c.name as category_name 
                FROM product p 
                LEFT JOIN category c ON p.category_id = c.id
                WHERE p.category_id = :category_id
                ORDER BY p.id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Lấy các sản phẩm đang có giảm giá (FLASH SALE)
    public function getFlashSaleProducts($limit = 4) {
        $query = "SELECT p.*, c.name as category_name 
                  FROM product p 
                  LEFT JOIN category c ON p.category_id = c.id
                  WHERE p.discount > 0
                  ORDER BY p.discount DESC
                  LIMIT :limit";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Hàm xóa sản phẩm khỏi Database
    public function deleteProduct($id) {
        $query = "DELETE FROM product WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>