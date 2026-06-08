<?php
class AuthController {
    private $conn;
    public function __construct() {
        require_once __DIR__ . '/../../../config/database.php';
        $this->conn = $conn;
    }
    public function processLogin(){
        // Same logic as public/proses_login.php but within MVC
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            header('Location: index.php?route=login');
            exit;
        }
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        if(empty($email) || empty($password)){
            header('Location: index.php?route=login&error=empty');
            exit;
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            header('Location: index.php?route=login&error=email');
            exit;
        }
        $stmt = $this->conn->prepare('SELECT id_user, nama_lengkap, password, role FROM users WHERE email = ? LIMIT 1');
        $stmt->bind_param('s',$email);
        $stmt->execute();
        $res = $stmt->get_result();
        if($res->num_rows===0){
            header('Location: index.php?route=login&error=invalid');
            exit;
        }
        $user = $res->fetch_assoc();
        if(!password_verify($password,$user['password'])){
            header('Location: index.php?route=login&error=invalid');
            exit;
        }
        // set session
        session_start();
        $_SESSION['id_user'] = $user['id_user'];
        $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
        $_SESSION['role'] = $user['role'];
        if($user['role']==='admin'){
            header('Location: index.php?route=dashboard');
        } else {
            header('Location: index.php?route=home');
        }
        exit;
    }

    public function processRegister(){
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            header('Location: index.php?route=register');
            exit;
        }
        $nama = trim($_POST['nama_lengkap'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $whatsapp = trim($_POST['no_whatsapp'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm = $_POST['konfirmasi_password'] ?? '';
        if(empty($nama)||empty($email)||empty($whatsapp)||empty($password)||empty($confirm)){
            header('Location: index.php?route=register&error=empty');
            exit;
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            header('Location: index.php?route=register&error=email');
            exit;
        }
        if(!preg_match('/^\d{10,15}$/',$whatsapp)){
            header('Location: index.php?route=register&error=whatsapp');
            exit;
        }
        if(strlen($password)<6){
            header('Location: index.php?route=register&error=short');
            exit;
        }
        if($password!==$confirm){
            header('Location: index.php?route=register&error=password');
            exit;
        }
        $stmt = $this->conn->prepare('SELECT id_user FROM users WHERE email = ? LIMIT 1');
        $stmt->bind_param('s',$email);
        $stmt->execute();
        $res = $stmt->get_result();
        if($res->num_rows>0){
            header('Location: index.php?route=register&error=exists');
            exit;
        }
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $role = 'customer';
        $stmt = $this->conn->prepare('INSERT INTO users (nama_lengkap, email, no_whatsapp, password, role) VALUES (?,?,?,?,?)');
        $stmt->bind_param('sssss',$nama,$email,$whatsapp,$hash,$role);
        if($stmt->execute()){
            header('Location: index.php?route=login&success=registered');
        } else {
            header('Location: index.php?route=register&error=failed');
        }
        exit;
    }

    public function showLogin() {
        session_start();
        include __DIR__ . '/../Views/login.php';
    }

    public function showRegister() {
        session_start();
        include __DIR__ . '/../Views/register.php';
    }
    // process login & register can be added as separate methods
}
?>
