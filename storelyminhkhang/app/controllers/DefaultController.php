<?php
require_once 'app/controllers/ProductController.php';

class DefaultController {
    public function index() {
        // Mặc định gọi luôn trang danh sách sản phẩm
        $product = new ProductController();
        $product->list();
    }
}
?>