<?php
// Usuario.php

require_once 'conexao.php'; // Inclua o arquivo de configuração

class Usuario {
    private $nome;
    private $senha;
    private $email;
    private $telefone;

    public function __construct($nome, $senha, $email, $telefone) {
        $this->nome = $nome;
        $this->senha = $senha;
        $this->email = $email;
        $this->telefone = $telefone;
    }

    public function salvarNoBanco() {
        global $pdo; // Acesse a conexão PDO global

        try {
            $sql = "INSERT INTO cliente (nome, senha, email, telefone) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$this->nome, $this->senha, $this->email, $this->telefone]);
            // Você pode adicionar outras lógicas aqui (validações, etc.)
        } catch (PDOException $e) {
            die("Erro ao salvar no banco de dados: " . $e->getMessage());
        }
    }
}
?>
