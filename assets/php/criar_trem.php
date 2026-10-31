<?php

require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../pages/tela_trens/tela_trens.php');
    exit;
}

$prefixo = $_POST['prefixo_trem'];
$modelo  = $_POST['modelo_trem'];
$ano     = filter_input(INPUT_POST, 'ano_trem', FILTER_VALIDATE_INT);
$linha   = $_POST['linhas'] ?? '';
$status  = $_POST['status_trem'] ?? '';

if ($prefixo === '' || $modelo === '' || $ano === false || $ano === null || $ano < 1800 || $ano > 2100 || !in_array($status, ['ativo', 'manutencao', 'parado'], true)) {
    exit('Dados inválidos. Verifique os campos do formulário.');
}

$id_linha = null;

if ($linha !== '') {
    $id_linha = filter_var($linha, FILTER_VALIDATE_INT);

    if ($id_linha === false || $id_linha <= 0) {
        exit('Linha selecionada inválida.');
    }

    $stmtLinha = $conexao->prepare('SELECT id_linha FROM linha WHERE id_linha = ?');

    $stmtLinha->bind_param('i', $id_linha);
    $stmtLinha->execute();

    $resultadoLinha = $stmtLinha->get_result();
    $linhaExiste = $resultadoLinha->num_rows > 0;

    $stmtLinha->close();

    if (!$linhaExiste) {
        exit('A linha selecionada não existe.');
    }
}

$pastaImagens = '../../assets/img/trens/';

if (!is_dir($pastaImagens)) {
    if (!mkdir($pastaImagens, 0755, true) && !is_dir($pastaImagens)) {
        exit('Não foi possível criar a pasta de imagens.');
    }
}

$caminhoImagem = null;
$arquivoSalvo = null;

if (
    isset($_FILES['imagem_trem']) &&
    $_FILES['imagem_trem']['error'] !== UPLOAD_ERR_NO_FILE
) {
    $imagem = $_FILES['imagem_trem'];

    if ($imagem['error'] !== UPLOAD_ERR_OK) {
        exit('Erro durante o envio da imagem.');
    }

    if ($imagem['size'] > 5 * 1024 * 1024) {
        exit('A imagem deve ter no máximo 5 MB.');
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($imagem['tmp_name']);

    $tiposPermitidos = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp'
    ];

    if (!isset($tiposPermitidos[$mime])) {
        exit('Formato inválido. Envie uma imagem JPG, PNG ou WEBP.');
    }

    $nomeArquivo = bin2hex(random_bytes(16))
        . '.' . $tiposPermitidos[$mime];

    $arquivoSalvo = $pastaImagens . $nomeArquivo;

    if (!move_uploaded_file($imagem['tmp_name'], $arquivoSalvo)) {
        exit('Não foi possível salvar a imagem.');
    }

    $caminhoImagem = '../../assets/img/trens/' . $nomeArquivo;
}

$sql = "INSERT INTO trem (prefixo_trem, modelo_trem, ano_trem, status_trem, imagem_trem, id_linha) VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conexao->prepare($sql);

if (!$stmt) {
    if ($arquivoSalvo !== null && file_exists($arquivoSalvo)) {
        unlink($arquivoSalvo);
    }

    exit('Erro ao preparar o cadastro do trem.');
}

$stmt->bind_param('ssissi', $prefixo, $modelo, $ano, $status, $caminhoImagem, $id_linha);

if ($stmt->execute()) {
    $stmt->close();
    $conexao->close();

    header('Location: ../../pages/tela_trens/tela_trens.php?cadastro_trem=sucesso');
    exit;
}

if ($arquivoSalvo !== null && file_exists($arquivoSalvo)) {
    unlink($arquivoSalvo);
}

$stmt->close();
$conexao->close();

http_response_code(500);
exit('Não foi possível cadastrar o trem. Tente novamente.');