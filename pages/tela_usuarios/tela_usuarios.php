<?php

require '../../assets/php/conexao.php';
require_once '../../assets/php/autorizacao.php';
require_once '../../assets/php/admin_auto.php';

$sql = "SELECT id_usuario, nome_usuario, email_usuario, tipo_usuario FROM usuario";
$resultado = $conexao->query($sql);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="stylesheet" href="../../assets/css/global.css">
    <link rel="stylesheet" href="style.css">

    <script src="main.js" defer></script>
    <script src="../../assets/js/global.js" defer></script> 

    <title>Track Flow || Usuários</title>
</head>

<body>
    <header>

        <div id="usuario"></div>
        <div id="conta"></div>

        <nav class="navbar">
            <div class="navbar_bloco">
                <button class="btn_navbar_menu" id="btn_menu"><i class="fa-solid fa-bars"></i></button>

                <div class="logo">
                    <img src="../../assets/img/logo_sem_fundo_branco.png" alt="logo">
                    <h6>Usuários</h6>
                </div>

                <button class="perfil" id="perfil"><img src="https://i.pinimg.com/736x/23/40/8e/23408e565fc3f43454636fec27572d1f.jpg" alt="perfil"></button>
            </div>

            <div class="menu_navbar">
                <ul>
                    <li><a href="../tela_dashboard/tela_dashboard.php">Dashboard</a></li>
                    <li><a href="../tela_relatorios/tela_relatorios.php">Relatórios</a></li>
                    <li><a href="../tela_sensores/tela_sensores.php">Sensores</a></li>
                    <li><a href="../tela_trens/tela_trens.php">Trens</a></li>
                    <li><a href="../tela_usuarios/tela_usuarios.php">Usuários</a></li>
                </ul>
            </div>
        </nav>

    </header>
    <main>

        <div class="container">
            <button class="botao" id="criar_usuario"><i class="fa-solid fa-plus"></i> Novo Usuário</button>

        <?php while ($usuario = $resultado->fetch_assoc()): ?>

            <div class="bloco estilo_primario">
                <div class="dados">
                    <ul>
                        <li>Nome: <span><?= htmlspecialchars($usuario['nome_usuario']) ?></span></li>
                        <li>Email: <span><?= htmlspecialchars($usuario['email_usuario']) ?></span></li>
                        <li>Tipo: <span><?= htmlspecialchars($usuario['tipo_usuario']) ?></span></li>
                    </ul>
                </div>
                <div class="opcoes">

                    <button type="button" class="botao editar_usuario" data-id="<?= $usuario['id_usuario'] ?>"><i class="fa-solid fa-pen-to-square"></i> Editar</button>
                    
                    <form action="../../assets/php/excluir_usuario.php" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir essa conta?');">
                        <input type="hidden" name="id_usuario" value="<?= $usuario['id_usuario'] ?>">
                        <button type="submit" class="botao"><i class="fa-solid fa-x"></i> Excluir</button>
                    </form>
                </div>
            </div>

        <?php endwhile; ?>
            
        </div>
    </main>
    <footer>
        <div class="marca_dagua">
            <small>Track Flow© 2026</small>
        </div>
    </footer>
</body>

</html>