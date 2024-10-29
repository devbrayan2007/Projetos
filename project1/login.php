<?php
require_once 'connection.php';
session_start(); // Inicia a sessão para usar $_SESSION

class Login {
    private $email;
    private $password;

    public function LoggingInUsers($email, $password) {
        $this->email = $email;
        $this->password = $password;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($e) {
        $this->email = $e;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($p) {
        $this->password = $p;
    }
}

class Authenticate extends Login {
    public function Enter(Login $l) {
        $conn = new Connection();
        $pdo = $conn->getConn();

        // Consulta para buscar o usuário com o email fornecido
        $stmt = $pdo->prepare("SELECT id, email, senha FROM usuarios WHERE email = :email");
        $stmt->bindParam(':email', $l->getEmail(), PDO::PARAM_STR);

        try {
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verifica se o email foi encontrado e a senha está correta
            if ($result && password_verify($l->getPassword(), $result['senha'])) {
                // Define a sessão com o ID do usuário para identificação nas próximas páginas
                $_SESSION['id'] = $result['id'];
                header('Location: dashboard.php'); // Redireciona para o dashboard
                exit;
            } else {
                echo "<h4>Email ou senha incorretos!</h4>";
            }
        } catch (PDOException $e) {
            echo "Erro de banco de dados: " . $e->getMessage();
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = new Login();
    $email = isset($_POST['email']) ? trim($_POST['email']) : null;
    $password = isset($_POST['password']) ? trim($_POST['password']) : null;

    $login->setEmail($email);
    $login->setPassword($password);

    $auth = new Authenticate();
    $auth->Enter($login);
} else {
    echo "<h4>Método de requisição inválido!</h4>";
}
