<?php
// 获取请求的 URI，去除查询字符串
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// 路由规则
switch ($request_uri) {
    case '/':
        // 主页
        echo 'Welcome to the homepage!';
        break;

    case '/about':
        // 关于页面
        echo 'This is the About page!';
        break;

    case '/contact':
        // 联系页面
        echo 'Contact us at contact@example.com';
        break;

    default:
        // 404 页面
        echo '404 Not Found';
        break;
}
?>
