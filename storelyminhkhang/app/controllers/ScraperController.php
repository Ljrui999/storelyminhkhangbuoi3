<?php
class ScraperController {
    
    public function fetch() {
        header('Content-Type: application/json'); 
        
        if (!isset($_POST['url']) || empty($_POST['url'])) {
            echo json_encode(['success' => false, 'message' => 'URL trống']);
            return;
        }

        $url = trim($_POST['url']);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15); 

        $html = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if (!$html || $httpcode !== 200) {
            echo json_encode(['success' => false, 'message' => 'Tường lửa của trang web đã chặn, hoặc link sai!']);
            return;
        }

        $doc = new DOMDocument();
        @$doc->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
        $xpath = new DOMXPath($doc);

        $name = '';
        $image = '';
        $description = '';
        $specsText = '';
        $price = '';

        // 1. LẤY TÊN SẢN PHẨM (Bao gồm cả Phiên bản)
        $metaTitle = $xpath->query('//meta[@property="og:title"]/@content');
        if ($metaTitle->length > 0) {
            $name = $metaTitle->item(0)->nodeValue;
            $name = explode('|', $name)[0]; 
            $name = str_replace(['Mua ', ' chính hãng', ' giá rẻ'], '', $name);
        }

        // 2. LẤY LINK HÌNH ẢNH 
        $metaImage = $xpath->query('//meta[@property="og:image"]/@content');
        if ($metaImage->length > 0) {
            $image = $metaImage->item(0)->nodeValue;
        }

        // 3. LẤY THÔNG SỐ KỸ THUẬT (MỚI THÊM)
        // Tìm các bảng cấu hình của CellphoneS (technical-content-item) hoặc TGDĐ (parameter)
        $specNodes = $xpath->query('//*[contains(@class, "technical-content-item")] | //*[contains(@class, "parameter")]//li');
        if ($specNodes->length > 0) {
            foreach ($specNodes as $node) {
                // Xóa các khoảng trắng thừa, ghép tên thông số và giá trị thành 1 dòng
                $text = trim(preg_replace('/\s+/', ' ', $node->nodeValue));
                if (!empty($text)) {
                    $specsText .= "• " . $text . "\n";
                }
            }
        }

        // 4. LẤY ĐẶC ĐIỂM NỔI BẬT 
        $descBox = $xpath->query('(//*[contains(@class, "cps-block-content_outstanding") or contains(@class, "parameter") or contains(@class, "text-short-description")])[1]');
        if ($descBox->length > 0) {
            $items = $xpath->query('.//li | .//p', $descBox->item(0));
            foreach ($items as $item) {
                $text = trim(strip_tags($item->nodeValue));
                if (!empty($text) && mb_strlen($text, 'UTF-8') > 5) {
                    $text = ltrim($text, '-·•+ ');
                    $description .= "- " . $text . "\n";
                }
            }
        }

        // 5. GỘP THÔNG SỐ VÀ ĐẶC ĐIỂM THÀNH 1 BÀI VIẾT ĐẸP MẮT
        $finalDescription = "";
        if (!empty($specsText)) {
            $finalDescription .= "🔧 THÔNG SỐ KỸ THUẬT:\n" . $specsText . "\n";
        }
        if (!empty($description)) {
            $finalDescription .= "🌟 ĐẶC ĐIỂM NỔI BẬT:\n" . $description;
        }
        // Dự phòng nếu cả 2 cái trên đều trống
        if (empty(trim($finalDescription))) {
            $metaDesc = $xpath->query('//meta[@property="og:description"]/@content');
            if ($metaDesc->length > 0) {
                $finalDescription = $metaDesc->item(0)->nodeValue;
            }
        }

        // 6. LẤY GIÁ BÁN 
        $priceNodes = $xpath->query('//*[contains(@class, "price") or contains(@class, "product__price--show")]');
        if ($priceNodes->length > 0) {
            foreach ($priceNodes as $node) {
                $text = $node->nodeValue;
                if (strpos($text, 'đ') !== false || strpos($text, '₫') !== false) {
                    $price = preg_replace('/[^0-9]/', '', $text); 
                    if(!empty($price)) break;
                }
            }
        }

        echo json_encode([
            'success' => true,
            'data' => [
                'name' => trim($name),
                'price' => $price,
                'image' => $image,
                'description' => trim($finalDescription)
            ]
        ]);
    }
}
?>