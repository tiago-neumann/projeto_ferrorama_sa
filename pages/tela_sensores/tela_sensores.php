<?php

require_once '../../assets/php/autorizacao.php';

$sql = "SELECT s.codigo_sensor, s.tipo_sensor, s.unidade_sensor, t.modelo_trem, t.prefixo_trem FROM sensor s INNER JOIN trem t ON s.id_trem = t.id_trem;";
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

    <title>Track Flow || Sensores</title>
</head> 

<body>
    <header>

        <div id="usuario"></div>
        <div id="sensor"></div>

        <nav class="navbar">
            <div class="navbar_bloco">
                <button class="btn_navbar_menu" id="btn_menu"><i class="fa-solid fa-bars"></i></button>

                <div class="logo">
                    <img src="../../assets/img/logo_sem_fundo_branco.png" alt="logo">
                    <h6>Sensores</h6>
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
            <div class="topo_sensores estilo_primario">
                <div>
                    <label for="pesquisa_sensor"><i class="fa-solid fa-magnifying-glass"></i></label>
                    <input type="text" name="pesquisa_sensor" class="input_padrao estilo_secundario" placeholder="Pesquise o sensor desejado">
                </div>

                <button id="criar_sensor" class="botao"><i class="fa-solid fa-plus"></i> Adicionar sensor</button>
            </div>

            <div class="tabela_sensores estilo_primario">
                <div class="lista_sensores estilo_secundario">
                    <table>

                        <tr>
                            <th>Código</th>
                            <th>Tipo</th>
                            <th>Unidade</th>
                            <th>Trem vinculado</th>
                        </tr>
                
                    <?php while($sensor = $resultado->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <button class="btn_editar"><i class="fa-solid fa-pen-to-square"></i></button>
                                <?= htmlspecialchars($sensor['codigo_sensor']) ?>
                            </td>
                            <td><?= htmlspecialchars($sensor['tipo_sensor']) ?></td>
                            <td><?= htmlspecialchars($sensor['unidade_sensor']) ?></td>
                            <td>
                                <?= htmlspecialchars($sensor['prefixo_trem']), " / ", htmlspecialchars($sensor['modelo_trem'])?>
                                <button class="btn_excluir"><i class="fa-solid fa-x"></i></button>
                            </td>
                        </tr>

                    <?php endwhile; ?>    

                    </table>
                </div>
            </div>
            

        </div>

    </main>
    <footer>
        <small class="marca_dagua">Track Flow© 2026</small>
    </footer>
</body>

</html>