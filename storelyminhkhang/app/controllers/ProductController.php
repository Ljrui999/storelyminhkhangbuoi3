<?php
require_once 'app/models/ProductModel.php';

class ProductController {
    private $productModel;

    public function __construct() {
        $this->productModel = new ProductModel();
    }

    // 1. Trang danh sách (Ai cũng xem được)
    public function list() {
        // 1. Lấy danh sách TẤT CẢ sản phẩm
        $products = $this->productModel->getAllProducts();
        
        // 2. LẤY DANH SÁCH 4 SẢN PHẨM FLASH SALE (Mới thêm)
        $flashSales = $this->productModel->getFlashSaleProducts(4);
        
        // 3. Lấy tất cả banner quảng cáo
        require_once 'app/models/BannerModel.php';
        $bannerModel = new BannerModel();
        $banners = $bannerModel->getAllBanners();
        
        // Gọi View
        require_once 'app/views/shares/header.php';
        require_once 'app/views/product/list.php';
        require_once 'app/views/shares/footer.php';
    }

    // 2. Thêm sản phẩm (CHỈ ADMIN)
    public function add() {
        // --- CHẶN BẢO MẬT TẠI ĐÂY ---
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            // Không phải admin thì đá về trang chủ ngay lập tức
            header("Location: /storelyminhkhang");
            exit();
        }

        require_once 'app/models/CategoryModel.php';
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->getAllCategories();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $price = $_POST['price'];
            $description = $_POST['description'];
            $category_id = $_POST['category_id'];
            $image = $_POST['image']; 
            $discount = isset($_POST['discount']) ? $_POST['discount'] : 0; // Lấy discount

            $result = $this->productModel->addProduct($name, $description, $price, $image, $category_id, $discount);
            
            if ($result) {
                header("Location: /storelyminhkhang/product/list");
                exit();
            }
        }

        require_once 'app/views/shares/header.php';
        require_once 'app/views/product/add.php';
        require_once 'app/views/shares/footer.php';
    }

    // 3. Sửa sản phẩm (CHỈ ADMIN)
    public function edit() {
        // --- CHẶN BẢO MẬT TẠI ĐÂY ---
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            // Không phải admin thì đá về trang chủ ngay lập tức
            header("Location: /storelyminhkhang");
            exit();
        }

        $url = isset($_GET['url']) ? explode('/', rtrim($_GET['url'], '/')) : [];
        $id = isset($url[2]) ? $url[2] : null;

        if (!$id) {
            echo "Lỗi: Không tìm thấy ID sản phẩm!";
            return;
        }

        require_once 'app/models/CategoryModel.php';
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->getAllCategories();
        $product = $this->productModel->getProductById($id);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $price = $_POST['price'];
            $description = $_POST['description'];
            $category_id = $_POST['category_id'];
            $image = $_POST['image'];
            $discount = isset($_POST['discount']) ? $_POST['discount'] : 0; // Lấy discount

            $result = $this->productModel->updateProduct($id, $name, $description, $price, $image, $category_id, $discount);
            
            if ($result) {
                header("Location: /storelyminhkhang/product/list");
                exit();
            }
        }

        require_once 'app/views/shares/header.php';
        require_once 'app/views/product/edit.php';
        require_once 'app/views/shares/footer.php';
    }

    // 4. Xem chi tiết sản phẩm (Ai cũng xem được)
    public function show() {
        $url = isset($_GET['url']) ? explode('/', rtrim($_GET['url'], '/')) : [];
        $id = isset($url[2]) ? $url[2] : null;

        if (!$id) {
            echo "<h2 class='text-center mt-5'>Lỗi: Không tìm thấy ID sản phẩm!</h2>";
            return;
        }

        $product = $this->productModel->getProductById($id);

        if (!$product) {
            echo "<h2 class='text-center mt-5'>Lỗi: Sản phẩm không tồn tại!</h2>";
            return;
        }

        require_once 'app/views/shares/header.php';
        require_once 'app/views/product/show.php';
        require_once 'app/views/shares/footer.php';
    }

    // 5. Hàm xử lý tìm kiếm (Ai cũng tìm được)
    public function search() {
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        
        if (empty($keyword)) {
            header("Location: /storelyminhkhang");
            exit();
        }

        $products = $this->productModel->searchProducts($keyword);

        require_once 'app/views/shares/header.php';
        echo "<div class='container mt-3'><h4>Kết quả tìm kiếm cho: <span class='text-danger'>".htmlspecialchars($keyword)."</span></h4></div>";
        require_once 'app/views/product/list.php';
        require_once 'app/views/shares/footer.php';
    }
    // Hàm xử lý lọc sản phẩm theo danh mục
    public function category() {
        $url = isset($_GET['url']) ? explode('/', rtrim($_GET['url'], '/')) : [];
        $category_id = isset($url[2]) ? $url[2] : null;

        if (!$category_id) {
            header("Location: /storelyminhkhang");
            exit();
        }

        // Lấy tên danh mục
        require_once 'app/models/CategoryModel.php';
        $categoryModel = new CategoryModel();
        $category = $categoryModel->getCategoryById($category_id);

        if (!$category) {
            header("Location: /storelyminhkhang");
            exit();
        }

        // Lấy các sản phẩm thuộc danh mục này
        $products = $this->productModel->getProductsByCategory($category_id);

        // Hiển thị ra giao diện (dùng lại list.php)
        require_once 'app/views/shares/header.php';
        echo "<div class='container mt-3 mb-2'><h4 class='fw-bold'>Danh mục: <span style='color: #d70018;'>".htmlspecialchars($category['name'])."</span></h4></div>";
        require_once 'app/views/product/list.php';
        require_once 'app/views/shares/footer.php';
    }
    // Hàm xử lý xóa sản phẩm
    public function delete() {
        // Chặn bảo mật: Chỉ Admin mới được xóa
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header("Location: /storelyminhkhang");
            exit();
        }

        $url = isset($_GET['url']) ? explode('/', rtrim($_GET['url'], '/')) : [];
        $id = isset($url[2]) ? $url[2] : null;

        if ($id) {
            $this->productModel->deleteProduct($id);
        }
        
        // Xóa xong thì load lại trang chủ
        header("Location: /storelyminhkhang");
        exit();
    }
}
?>