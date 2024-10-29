<?php

require_once 'connection.php';

class Cadastro {
    private $username;
    private $password;
    private $email;

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = htmlspecialchars($username);
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = filter_var($email, FILTER_SANITIZE_EMAIL);
    }
}

class Registrar extends Cadastro {

    public function EnterData(Cadastro $c) {
        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
        $register = Connection::getConn()->prepare($sql);

        $register->bindValue(1, $c->getUsername());
        $register->bindValue(2, $c->getEmail());
        $register->bindValue(3, $c->getPassword());

        if ($register->execute()) {
            echo "Dados inseridos com sucesso!";
            header('Location: dashboard.php'); // Redireciona após o cadastro bem-sucedido
            exit;
        } else {
            echo "Erro ao se cadastrar!";
        }
    }
}

// Recebe e valida os dados enviados via POST
$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

// Verifica se os campos obrigatórios estão preenchidos
if (empty($username) || empty($email)) {
    echo "Nome e email são obrigatórios.";
    exit;
}

// Cria o usuário e cadastra
$user = new Cadastro();
$user->setUsername($username);
$user->setEmail($email);
$user->setPassword($password);

$log = new Registrar();
$log->EnterData($user);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOG</title>
</head>
<body>
    <h2>Cadastro</h2>
</body>
</html>
