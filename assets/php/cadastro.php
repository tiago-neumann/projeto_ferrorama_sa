<?php

session_start();

//Puxa a conexao feita com o banco de dados na pasta php
require 'conexao.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $erro = "";

    //Pega os daods digitados nos campos e transforma eles em variáveis
    $nome = trim($_POST['nome_usuario']);
    $email = trim($_POST['email_usuario']);
    $senha = $_POST['senha_usuario'];
    $confirmar_senha = $_POST['confirmar_senha'];

    //Verifica se todos os campos foram preenchidos
    if (empty($nome) || empty($email) || empty($senha) || empty($confirmar_senha)){

        $erro = "Preencha todos os campos!";

    //Verifica se a senha foi digitada certa
    } elseif ($senha !== $confirmar_senha){

        $erro = "As senhas não são iguais.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){

        $erro = "Digite um email válido!";

    } elseif (!checkdnsrr(substr(strrchr($email, "@"), 1), "MX")){

        $erro = "O domínio deste e-mail não pode receber e-emails.";

    } else {

        //Verifica se o email não esta repetido
        $sql_verifica = "SELECT id_usuario FROM usuario WHERE email_usuario = ?";
        $stmt_verifica = $conexao->prepare($sql_verifica);

        $stmt_verifica->bind_param("s", $email);
        $stmt_verifica->execute();

        $resultado = $stmt_verifica->get_result();

        if($resultado->num_rows > 0) {

            $erro = "Este e-mail já existe.";

        } else {
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

            $sql = "INSERT INTO usuario (nome_usuario, email_usuario, senha_usuario) VALUES (?, ?, ?)";

            $stmt = $conexao->prepare($sql);

            $stmt->bind_param("sss", $nome, $email, $senha_hash);

            if ($stmt->execute()) {

            header('Location: ../tela_login/tela_login.php');
            exit;

            } else {

                if($stmt->errno === 1062){

                $erro = "Este e-mail já esta cadastrado";

                } else {

                $erro = "Erro ao realizar o cadastro.";

                }
            }
        }
    }
}

?>