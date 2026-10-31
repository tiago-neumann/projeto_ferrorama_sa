<?php

session_start();

require_once __DIR__ . '/../php/conexao.php';

$id_usuario = filter_input(INPUT_GET, 'id_usuario', FILTER_VALIDATE_INT);

if (!$id_usuario || $id_usuario <= 0) {
    http_response_code(400);
    exit('ID de usuário inválido.');
}

$sql = "SELECT id_usuario, nome_usuario, email_usuario, tipo_usuario FROM usuario WHERE id_usuario = ?";

$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();

$resultado = $stmt->get_result();
$usuario = $resultado->fetch_assoc();

$stmt->close();

if (!$usuario) {
    http_response_code(404);
    exit('Usuário não encontrado.');
}

?>

<div class="conta">
    <div class="bloco_conta estilo_primario">
        <div class="ajuste_conta">
            <h1>Editar usuário</h1>
            <button class="btn_fechar" id="fechar_conta"><i class="fa-solid fa-x"></i></button>
        </div>
                
        <div class="bloco_conta estilo_secundario">
            <form action="../../assets/php/editar_usuario.php" method='POST'>

                <input type="hidden" name="id_usuario" value="<?= $usuario['id_usuario'] ?>">

                <div class="separacao">
                    <input class="input_padrao estilo_secundario" type="text" name="nome_usuario" placeholder="Nome" value="<?= htmlspecialchars($usuario['nome_usuario']) ?>" required>

                    <input class="input_padrao estilo_secundario" type="email" name="email_usuario" placeholder="Email" value="<?= htmlspecialchars($usuario['email_usuario']) ?>" required>

                    <input class="input_padrao estilo_secundario" type="password" name="senha_usuario" placeholder="Nova senha (opcional)" autocomplete="new-password">

                    <div class="opcoes_usuario">
                        <label class="opcao_usuario estilo_secundario">
                            <input type="radio" name="tipo_usuario" value="usuario" <?= $usuario['tipo_usuario'] === 'usuario' ? 'checked' : '' ?>>
                            <span>Usuário</span>
                        </label>
                        <label class="opcao_usuario estilo_secundario">
                            <input type="radio" name="tipo_usuario" value="admin" <?= $usuario['tipo_usuario'] === 'admin' ? 'checked' : '' ?>>
                            <span>Admin</span>
                        </label>
                    </div>
                </div>

                    <button type="submit" class="botao extensao_botao"><i class="fa-solid fa-check"></i> Confirmar edição</button>
            </form>             
        </div>
    </div>     
</div>