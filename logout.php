<?php
// Khởi động session
session_start();

// Hủy bỏ tất cả các biến session
session_unset();

// Hủy bỏ phiên làm việc
session_destroy();

// Chuyển hướng người dùng đến trang đăng nhập
header("Location: signin_page.php");
exit();
?>
