<?php
// processa_login.php

require_once 'usuario.php'; // Inclua a classe Usuario

// Recebe os dados do formulário
$nome = $_POST['nome'];
$senha = $_POST['senha'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];

// Cria um objeto Usuario
$usuario = new Usuario($nome, $senha, $email, $telefone);

// Salva no banco de dados
$usuario->salvarNoBanco();

// Redireciona o usuário após o login
header('Location: dashboard.php');
exit;
?>
