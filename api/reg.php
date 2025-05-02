<?php 
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

// 检查是否已经为当前用户设置过请求记录
if (!isset($_SESSION['requests'][$userIp])) {
    $_SESSION['requests'][$userIp] = [];
}

// 清理过期的请求
foreach ($_SESSION['requests'][$userIp] as $key => $request) {
    if ($request < $currentTime - $timeWindow) {
        unset($_SESSION['requests'][$userIp][$key]);
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





// 创建连接
$connection = mysqli_connect('154.40.45.50', 'uhup_user', 'gg20130428', 'uhup');

// 检查连接
if (!$connection) {
    die("连接失败: " . mysqli_connect_error());
}

// 执行查询
$sql = "SELECT id, name FROM users";
$result = mysqli_query($connection, $sql);

// 检查结果并输出
if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        echo "id: " . $row["id"] . " - Name: " . $row["name"] . "<br>";
    }
} else {
    echo "0 结果";
}

// 关闭连接
mysqli_close($connection);


?>