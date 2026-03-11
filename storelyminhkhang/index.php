<?php
session_start(); // <-- THÊM DÒNG NÀY ĐỂ LƯU TRẠNG THÁI ĐĂNG NHẬP
// Bật hiển thị lỗi để dễ sửa code
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Lấy URL, nếu không có gì thì gọi mặc định vào DefaultController
$url = (isset($_GET['url']) && $_GET['url'] !== '') ? $_GET['url'] : 'default/index';
$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

// Lấy tên Controller và Method (Hàm)
$controllerName = ucfirst($url[0]) . 'Controller'; 
$methodName = isset($url[1]) ? $url[1] : 'index';

$controllerFile = 'app/controllers/' . $controllerName . '.php';

// Kiểm tra và chạy Controller
if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $controller = new $controllerName();
    
    if (method_exists($controller, $methodName)) {
        $controller->$methodName();
    } else {
        echo "Lỗi: Không tìm thấy chức năng '$methodName' trong $controllerName";
    }
} else {
    echo "Lỗi: Không tìm thấy file Controller '$controllerFile'";
}
?>