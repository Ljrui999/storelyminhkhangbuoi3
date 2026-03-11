<?php
require_once 'app/models/BannerModel.php';

class BannerController {
    private $bannerModel;

    public function __construct() {
        // Chỉ admin mới được vào
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header("Location: /storelyminhkhang");
            exit();
        }
        $this->bannerModel = new BannerModel();
    }

    // Hiển thị và thêm banner
    public function index() {
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $image_url = trim($_POST['image_url']);
            if (!empty($image_url)) {
                $this->bannerModel->addBanner($image_url);
                $success = "Thêm quảng cáo thành công!";
            }
        }

        $banners = $this->bannerModel->getAllBanners();

        require_once 'app/views/shares/header.php';
        require_once 'app/views/banner/index.php';
        require_once 'app/views/shares/footer.php';
    }

    // Xóa banner
    public function delete() {
        $url = isset($_GET['url']) ? explode('/', rtrim($_GET['url'], '/')) : [];
        $id = isset($url[2]) ? $url[2] : null;

        if ($id) {
            $this->bannerModel->deleteBanner($id);
        }
        header("Location: /storelyminhkhang/banner");
        exit();
    }
}
?>