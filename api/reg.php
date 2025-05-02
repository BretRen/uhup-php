<?php 
// 设置返回格式为 JSON
header(header: 'Content-Type: application/json');

// 允许跨域（开发时用）
header(header: 'Access-Control-Allow-Origin: *');

session_start(); // 启用会话

// 设置最大请求次数和时间窗口（秒）
$maxRequests = 5;
$timeWindow = 60; // 60秒内最多5次请求

// 获取用户 IP 和当前时间
$userIp = $_SERVER['REMOTE_ADDR'];
$currentTime = time();

// 使用会话存储每个用户的请求时间
if (!isset($_SESSION['requests'])) {
    $_SESSION['requests'] = [];
}

// 清理过期的请求
foreach ($_SESSION['requests'] as $key => $request) {
    if ($request < $currentTime - $timeWindow) {
        unset($_SESSION['requests'][$key]);
    }
}

// 检查用户请求次数
if (count($_SESSION['requests'][$userIp]) >= $maxRequests) {
    // 超过限制，返回 429 状态码（Too Many Requests）
    http_response_code(429);
    echo json_encode(['error' => '请求过于频繁，请稍后再试']);
    exit;
}

// 记录当前请求
$_SESSION['requests'][$userIp][] = $currentTime;



?>