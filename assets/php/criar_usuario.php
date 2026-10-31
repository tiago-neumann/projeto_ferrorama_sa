
<?php

session_start();

require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../pages/tela_usuarios/tela_usuarios.php');
    exit;
}

$nome_usuario = trim($_POST['nome_usuario'] ?? '');
$email_usuario = trim($_POST['email_usuario'] ?? '');
$senha_usuario = $_POST['senha_usuario'] ?? '';
$tipo_usuario = $_POST['tipo_usuario'] ?? 'usuario';

if (
    strlen($nome_usuario) < 2 ||
    strlen($nome_usuario) > 100 ||
    $email_usuario === '' ||
    strlen($email_usuario) > 150 ||
    !filter_var($email_usuario, FILTER_VALIDATE_EMAIL) ||
    $senha_usuario === '' ||
    !in_array($tipo_usuario, ['usuario', 'admin'], true)
) {
    http_response_code(400);
    exit('Preencha os campos corretamente.');
}

$senha_hash = password_hash($senha_usuario, PASSWORD_DEFAULT);

$sql = "INSERT INTO usuario (nome_usuario, email_usuario, senha_usuario, tipo_usuario) VALUES (?, ?, ?, ?)";

$stmt = $conexao->prepare($sql);
$stmt->bind_param("ssss", $nome_usuario, $email_usuario, $senha_hash, $tipo_usuario);

if ($stmt->execute()) {

    $stmt->close();
    header('Location: ../../pages/tela_usuarios/tela_usuarios.php?cadastro=sucesso');
    exit;

} else {

    $codigo_erro = $stmt->errno;

    $stmt->close();

    if ($codigo_erro === 1062) {
        http_response_code(409);
        exit('Este e-mail já está cadastrado.');
    }

    http_response_code(500);
    exit('Não foi possível cadastrar o usuário.');
}
