<!DOCTYPE html>
<?php
require_once 'app/models/CategoryModel.php';
$headerCategoryModel = new CategoryModel();
$headerCategories = $headerCategoryModel->getAllCategories();
?>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LJRUI - Điện Thoại | Laptop | Phụ Kiện</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f6f8; /* Nền xám nhạt làm nổi bật sản phẩm */
        }
        .navbar-custom {
            background-color: #d70018; /* Đỏ đặc trưng CellphoneS */
        }
        .search-box {
            border-radius: 20px;
            padding-left: 20px;
            border: none;
        }
        .product-card {
            transition: transform 0.2s, box-shadow 0.2s;
            cursor: pointer;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom mb-4 sticky-top shadow">
        <div class="container">
            <a class="navbar-brand" href="/storelyminhkhang">
                <img src="/storelyminhkhang/assets/logo.png" alt="LJRUI Logo" style="height: 50px; background-color: white; border-radius: 8px; padding: 2px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
            
                
                <div class="dropdown me-3">
                    <button class="btn dropdown-toggle rounded-pill text-white fw-bold d-flex align-items-center" type="button" data-bs-toggle="dropdown" style="background-color: rgba(255,255,255,0.2); border: none; padding: 10px 20px;">
                        <i class="fa-solid fa-bars me-2 fs-5"></i> Danh mục
                    </button>
                    <ul class="dropdown-menu shadow-lg border-0 mt-2 rounded-3">
                        <?php foreach($headerCategories as $cat): ?>
                            <li>
                                <a class="dropdown-item py-2 fw-medium" href="/storelyminhkhang/product/category/<?= $cat['id'] ?>">
                                    <i class="fa-solid fa-angle-right me-2 text-muted" style="font-size: 0.8rem;"></i> <?= htmlspecialchars($cat['name']) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                
                
                <form class="d-flex mx-auto w-50 my-2 my-lg-0" action="/storelyminhkhang/product/search" method="GET">
                    <input class="form-control search-box shadow-sm" type="search" name="keyword" placeholder="Bạn cần tìm điện thoại, laptop..." value="<?= isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : '' ?>" required>
                    <button class="btn btn-dark ms-2 rounded-circle" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>

                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link text-white fw-medium d-flex align-items-center" href="/storelyminhkhang/cart">
                            <i class="fa-solid fa-cart-shopping me-1"></i> Giỏ hàng
                            <?php 
                            $cart_count = 0;
                            if(isset($_SESSION['cart'])) {
                                foreach($_SESSION['cart'] as $item) {
                                    $cart_count += $item['quantity'];
                                }
                            }
                            if($cart_count > 0): 
                            ?>
                                <span class="badge bg-warning text-dark rounded-pill ms-2"><?= $cart_count ?></span>
                            <?php endif; ?>
                        </a>
                    </li>
                    
                    <?php if(isset($_SESSION['user'])): ?>
                        <li class="nav-item dropdown ms-2">
                            <a class="nav-link dropdown-toggle text-white fw-bold" href="#" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-user-circle me-1"></i> <?= htmlspecialchars($_SESSION['user']['username']) ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                <?php if($_SESSION['user']['role'] === 'admin'): ?>
                                    <li><span class="dropdown-item-text text-muted small">Quyền: Quản trị viên</span></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item fw-bold text-primary" href="/storelyminhkhang/order"><i class="fa-solid fa-list-check me-2"></i>Quản lý đơn hàng</a></li>
                                    <li><a class="dropdown-item fw-bold text-success" href="/storelyminhkhang/banner"><i class="fa-solid fa-image me-2"></i>Quản lý quảng cáo</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                <?php endif; ?>
                                <li>
                                    <a class="dropdown-item text-danger" href="/storelyminhkhang/auth/logout" onclick="return confirm('Nếu bạn đăng xuất web Lý Minh Khang sẽ xoá dữ liệu giỏ hàng hiện đang có. Bạn có chắc chắn muốn thoát?');">
                                        <i class="fa-solid fa-right-from-bracket me-2"></i>Đăng xuất
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link text-white fw-medium" href="/storelyminhkhang/auth/login"><i class="fa-regular fa-user me-1"></i> Đăng nhập</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-warning fw-bold" href="/storelyminhkhang/auth/register"><i class="fa-solid fa-user-plus me-1"></i> Đăng ký</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">