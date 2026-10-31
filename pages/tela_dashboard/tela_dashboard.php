<?php

require_once '../../assets/php/autorizacao.php';

$sql = "SELECT * FROM trem";
$resultado = $conexao->query($sql);

$trens = [];
$totalAtivos = 0;
$totalManutencao = 0;
$totalParados = 0;

while ($trem = $resultado->fetch_assoc()) {
    $trens[] = $trem;

    switch ($trem['status_trem']) {
        case 'ativo':
            $totalAtivos++;
            break;

        case 'manutencao':
            $totalManutencao++;
            break;

        case 'parado':
            $totalParados++;
            break;
    }
}

$totalTrens = count($trens);

$porcentagemAtivos = $totalTrens > 0
    ? round(($totalAtivos * 100) / $totalTrens)
    : 0;

$porcentagemManutencao = $totalTrens > 0
    ? round(($totalManutencao * 100) / $totalTrens)
    : 0;

$porcentagemParados = $totalTrens > 0
    ? round(($totalParados * 100) / $totalTrens)
    : 0;

$limiteParados = $porcentagemParados;
$limiteManutencao = $limiteParados + $porcentagemManutencao;
$limiteAtivos = 100;

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

    <title>Track Flow || Dashboard</title>
</head>

<body>

    <header>

        <div id="usuario"></div>

        <nav class="navbar">
            <div class="navbar_bloco">
                <button class="btn_navbar_menu" id="btn_menu"><i class="fa-solid fa-bars"></i></button>

                <div class="logo">
                    <img src="../../assets/img/logo_sem_fundo_branco.png" alt="logo">
                    <h6>Dashboard</h6>
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

            <div class="status_trens estilo_primario">
                <div class="status estilo_secundario">
                    <i class="status_verde fa-solid fa-check"></i>

                    <div>
                        <p><strong>Trens ativos</strong></p>
                        <small class="quantidade_status"><span><?= htmlspecialchars($totalAtivos) ?></span> de <?= htmlspecialchars($totalTrens) ?></small>
                        <input class="barra_verde" type="range" style="--progresso-verde: <?=$porcentagemAtivos?>%;" disabled>
                    </div>
                </div>

                <div class="status estilo_secundario">
                    <i class="status_amarelo fa-solid fa-gear"></i>

                    <div>
                        <p><strong>Trens em manutenção</strong></p>
                        <small class="quantidade_status"><span><?= htmlspecialchars($totalManutencao) ?></span> de <?= htmlspecialchars($totalTrens) ?></small>
                        <input class="barra_amarela" type="range" style="--progresso-amarelo: <?=$porcentagemManutencao?>%;" disabled>
                    </div>
                </div>

                <div class="status estilo_secundario">
                    <i class="status_vermelho fa-solid fa-stop"></i>

                    <div>
                        <p><strong>Trens parados</strong></p>
                        <small class="quantidade_status"><span><?= htmlspecialchars($totalParados) ?></span> de <?= htmlspecialchars($totalTrens) ?></small>
                        <input class="barra_vermelha" type="range" style="--progresso-vermelho: <?=$porcentagemParados?>%;" disabled>
                    </div>
                </div>
            </div>

            <div class="grafico_trens estilo_primario">
                <div class="bloco_grafico">
                    <p><strong>Estado dos Trens</strong></p>
                    <small>Distribuição da frota por status</small>

                    <div class="grafico" style="--limite-parados: <?= $limiteParados ?>%; --limite-manutencao: <?= $limiteManutencao ?>%; --limite-ativos: <?= $limiteAtivos ?>%;"></div>
                </div>

                <div class="dados_grafico estilo_secundario">
                    <table>
                        <tr>
                            <th>Status</th>
                            <th>Quantidade</th>
                            <th>Porcentagem</th>
                        </tr>

                        <tr>
                            <td><i class="bola_verde fa-solid fa-circle"></i> Ativo</td>
                            <td><?= htmlspecialchars($totalAtivos) ?></td>
                            <td><?=$porcentagemAtivos?>%</td>
                        </tr>

                        <tr>
                            <td><i class="bola_amarela fa-solid fa-circle"></i> Manutenção</td>
                            <td><?= htmlspecialchars($totalManutencao) ?></td>
                            <td><?=$porcentagemManutencao?>%</td>
                        </tr>

                        <tr>
                            <td><i class="bola_vermelha fa-solid fa-circle"></i> Parado</td>
                            <td><?= htmlspecialchars($totalParados) ?></td>
                            <td><?=$porcentagemParados?>%</td>
                        </tr>
            
                    </table>
                </div>
            </div>

            <div class="lista_trens estilo_primario">
                <div class="topo_lista_trens">
                    <div class="lista_trens_info">
                        <p><strong>Catálogo de Trens</strong></p>
                        <small>Todos os trens cadastrados no sistema</small>
                    </div>

                    <div class="pesquisa">
                        <label for="pesquisa"><i class="fa-solid fa-magnifying-glass"></i></label>
                        <input class="input_padrao estilo_secundario" type="text" name="pesquisa" id="pesquisa" placeholder="Pesquise um trem">
                    </div>
                </div>

                <div class="catalogo estilo_secundario">
                    <table>
                        <tr>
                            <th>Prefixo</th>
                            <th>Modelo</th>
                            <th>Status</th>
                            <th>Linha</th>
                            <th>Ano</th>
                        </tr>

                        <?php foreach($trens as $trem): ?>

                        <tr>
                            <td><?= htmlspecialchars($trem['prefixo_trem']) ?? "--" ?></td>
                            <td><?= htmlspecialchars($trem['modelo_trem']) ?? "--" ?></td>
                            <td class="status_<?= match ($trem['status_trem']){ 
                                'ativo' => 'ativo',
                                'manutencao' => 'manutencao',
                                'parado' => 'parado'
                            } ?>"><?= match ($trem['status_trem']) {
                                'ativo' => htmlspecialchars("Ativo"),
                                'manutencao' => htmlspecialchars("Manutenção"),
                                'parado' => htmlspecialchars("Parado")
                            } ?? "--" ?></td>
                            <td><?= htmlspecialchars($trem['id_linha'] ?? "--") ?></td>
                            <td><?= htmlspecialchars($trem['ano_trem']) ?? "--" ?></td>
                        </tr>

                        <?php endforeach; ?>

                    </table>
                </div>
            </div>

            <div class="aviso estilo_primario">
                <p><strong><i class="fa-solid fa-bell"></i> Avisos</strong></p>
                
                <div class="estilo_secundario">

                </div>
            </div>

            <div class="ocorrencias estilo_primario">
                <p><strong><i class="fa-solid fa-clock"></i> Ocorrências</strong></p>

                <div class="estilo_secundario">

                </div>
            </div>

        </div>

    </main>
    <footer>
        <small class="marca_dagua">Track Flow© 2026</small>
    </footer>
</body>

</html>