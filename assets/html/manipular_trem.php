<?php

require '../../assets/php/conexao.php';

$id_trem = filter_input(INPUT_GET, 'id_trem', FILTER_VALIDATE_INT);

$stmt = $conexao->prepare('SELECT * FROM trem WHERE id_trem = ?');
$stmt->bind_param('i', $id_trem);
$stmt->execute();

$trem = $stmt->get_result()->fetch_assoc();
$stmt->close();

$resultado_linhas = $conexao->query('SELECT id_linha, nome_linha FROM linha ORDER BY nome_linha');

?>

<div class="conta">
    <div class="bloco_conta estilo_primario">

        <div class="ajuste_conta">
            <h1>Editar Trem</h1>

            <button type="button" class="btn_fechar" id="fechar_conta">
                <i class="fa-solid fa-x"></i>
            </button>
        </div>

        <div class="bloco_conta estilo_secundario">
            <form action="../../assets/php/editar_trem.php" method="POST" enctype="multipart/form-data" class="form_trem">
                <input type="hidden" name="id_trem" value="<?= $trem['id_trem'] ?>">

                <div class="separacao">

                    <div class="campo_imagem estilo_secundario">
                        <input class="input_arquivo" type="file" id="imagem_trem" name="imagem_trem" accept="image/jpeg, image/png, image/webp">

                        <label for="imagem_trem" class="seletor_imagem">
                            <i class="fa-solid fa-cloud-arrow-up"></i>

                            <span class="texto_imagem">
                                <strong>Escolha uma imagem</strong>
                                <small>JPEG, PNG ou WebP</small>
                            </span>

                            <span class="botao botao_imagem">Selecionar</span>
                        </label>

                        <p class="nome_arquivo" id="nome_arquivo">Nenhum arquivo selecionado</p>
                    </div>

                    <input class="input_padrao estilo_secundario" type="text" name="prefixo_trem" placeholder="Prefixo | ex: BR 403" value="<?= htmlspecialchars($trem['prefixo_trem'])?>" maxlength="100" required>

                    <input class="input_padrao estilo_secundario" type="text" name="modelo_trem" placeholder="Modelo | ex: Siemens Velaro" value="<?= htmlspecialchars($trem['modelo_trem']) ?>" maxlength="100" required>

                    <input class="input_padrao estilo_secundario" type="number" name="ano_trem" placeholder="Ano de criação" value="<?= htmlspecialchars($trem['ano_trem']) ?>" min="1800" max="2100" required>

                    <select class="input_padrao estilo_secundario" name="linhas">
                        <option value="">Sem linha</option>

                        <?php while ($linha = $resultado_linhas->fetch_assoc()): ?>
                            <option value="<?= $linha['id_linha'] ?>" <?= ($trem['id_linha'] ?? 0) === $linha['id_linha'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($linha['nome_linha']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>

                    <div class="opcoes_usuario">

                        <?php $status_opcoes = ['ativo' => 'Ativo', 'manutencao' => 'Manutenção', 'parado' => 'Parado']; ?>

                        <?php foreach ($status_opcoes as $valor => $rotulo): ?>
                            <label class="opcao_usuario estilo_secundario">
                                <input type="radio" name="status_trem" value="<?= $valor ?>" <?= $trem['status_trem'] === $valor ? 'checked' : '' ?> required>
                                <span><?= $rotulo ?></span>
                            </label>
                        <?php endforeach; ?>

                    </div>
                </div>

                <button type="submit" class="botao extensao_botao"><i class="fa-solid fa-check"></i> Salvar Alterações</button>
            </form>
        </div>
    </div>
</div>