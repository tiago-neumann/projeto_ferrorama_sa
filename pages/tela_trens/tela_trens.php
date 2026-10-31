<?php

require_once '../../assets/php/autorizacao.php';

$sql = "SELECT * FROM trem";
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

    <title>Track Flow || Trens</title>
</head>

<body>
    <header>

        <div id="usuario"></div>
        <div id="trem"></div>

        <nav class="navbar">
            <div class="navbar_bloco">
                <button class="btn_navbar_menu" id="btn_menu"><i class="fa-solid fa-bars"></i></button>

                <div class="logo">
                    <img src="../../assets/img/logo_sem_fundo_branco.png" alt="logo">
                    <h6>Trens</h6>
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

            <button id="criar_trem" class="botao"><i class="fa-solid fa-plus"></i> Adicionar Trem</button>

            <?php while ($trem = $resultado->fetch_assoc()): ?>

                <div class="card">
                    <img src="<?= htmlspecialchars($trem['imagem_trem']) ?: "../../assets/img/trem_bala.png" ?>" alt="trem">

                    <div class="dados">
                        <ul>
                            <li>ID: <span><?= htmlspecialchars($trem['id_trem']) ?></span></li>
                            <li>Prefixo: <span><?= htmlspecialchars($trem['prefixo_trem']) ?></span></li>
                            <li>Modelo: <span><?= htmlspecialchars($trem['modelo_trem']) ?></span></li>
                        </ul>
                        <ul>
                            <li>Ano: <span><?= htmlspecialchars($trem['ano_trem']) ?></span></li>
                            <li>Status: <span><?= htmlspecialchars($trem['status_trem']) ?></span></li>
                            <li>Linha: <span><?= htmlspecialchars($trem['id_linha'] ?? "Sem linha") ?></span></li>
                        </ul>
                    </div>

                    <div class="divisao_btn">
                        <button type="button" id="editar_trem" class="botao" data-id="<?= $trem['id_trem'] ?>">Editar</button>
                    
                        <form action="../../assets/php/excluir_trem.php" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esse trem?');">
                            <input type="hidden" name="id_trem" value="<?= $trem['id_trem'] ?>">
                            <button type="submit" class="botao">Excluir</button>
                        </form>
                    </div>
                </div>

            <?php endwhile; ?>

    </main>
    <footer>
        <small class="marca_dagua">Track Flow© 2026</small>
    </footer>
</body>

</html>