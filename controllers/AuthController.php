<?php
class AuthController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function login() {
        $redirect = isset($_GET['redirect']) ? $_GET['redirect'] : '';

        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';
            $password = isset($_POST['password']) ? trim($_POST['password']) : '';

            if ($email === '' || $password === '') {
                $error = 'Vui lòng nhập email và mật khẩu.';
            } else {
                $sql = "SELECT * FROM users WHERE email = ? LIMIT 1";
                $stmt = mysqli_prepare($this->conn, $sql);
                mysqli_stmt_bind_param($stmt, "s", $email);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                if ($result && mysqli_num_rows($result) > 0) {
                    $user = mysqli_fetch_assoc($result);
                    // Lưu ý: mật khẩu đang lưu plaintext trong database. Nếu mã hóa, cần dùng password_verify.
                    if ($user['password'] === $password) {
                        // Lưu thông tin vào session
                        $_SESSION['user_id']   = $user['user_id'];
                        $_SESSION['user_name'] = $user['full_name'];
                        $_SESSION['full_name'] = $user['full_name']; // thêm nếu cần
                        $_SESSION['email']     = $user['email'];
                        $_SESSION['role']      = $user['role']; // *** THÊM DÒNG NÀY ***

                        // Chuyển hướng
                        if (!empty($redirect)) {
                            header('Location: ' . htmlspecialchars($redirect));
                        } else {
                            // Nếu là admin thì vào trang quản trị
                            if ($user['role'] === 'admin') {
                                header('Location: views/admin/index.php');
                            } else {
                                header('Location: index.php');
                            }
                        }
                        exit();
                    } else {
                        $error = 'Email hoặc mật khẩu không đúng.';
                    }
                } else {
                    $error = 'Email hoặc mật khẩu không đúng.';
                }
            }
        }

        include 'views/layouts/header.php';
        include 'views/auth/login.php';
        include 'views/layouts/footer.php';
    }

    public function register() {
        $redirect = isset($_GET['redirect']) ? $_GET['redirect'] : '';

        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $full_name = isset($_POST['full_name']) ? trim($_POST['full_name']) : '';
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';
            $password = isset($_POST['password']) ? trim($_POST['password']) : '';
            $confirm_password = isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : '';

            if ($full_name === '' || $email === '' || $password === '' || $confirm_password === '') {
                $error = 'Vui lòng điền đầy đủ thông tin.';
            } elseif ($password !== $confirm_password) {
                $error = 'Mật khẩu và xác nhận mật khẩu không khớp.';
            } else {
                // Kiểm tra email tồn tại
                $sql = "SELECT * FROM users WHERE email = ? LIMIT 1";
                $stmt = mysqli_prepare($this->conn, $sql);
                mysqli_stmt_bind_param($stmt, "s", $email);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                if ($result && mysqli_num_rows($result) > 0) {
                    $error = 'Email đã được đăng ký.';
                } else {
                    $sqlInsert = "INSERT INTO users (full_name, email, password, role, created_at) VALUES (?, ?, ?, 'customer', NOW())";
                    $stmtInsert = mysqli_prepare($this->conn, $sqlInsert);
                    mysqli_stmt_bind_param($stmtInsert, "sss", $full_name, $email, $password);
                    $execute = mysqli_stmt_execute($stmtInsert);

                    if ($execute) {
                        $_SESSION['user_id'] = mysqli_insert_id($this->conn);
                        $_SESSION['user_name'] = $full_name;

                        if (!empty($redirect)) {
                            header('Location: ' . htmlspecialchars($redirect));
                        } else {
                            header('Location: index.php');
                        }
                        exit();
                    } else {
                        $error = 'Đã xảy ra lỗi khi đăng ký. Vui lòng thử lại.';
                    }
                }
            }
        }

        include 'views/layouts/header.php';
        include 'views/auth/register.php';
        include 'views/layouts/footer.php';
    }

    public function logout() {
        session_unset();
        session_destroy();
        header('Location: index.php');
        exit();
    }
}
?>