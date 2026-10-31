<?php

require '../../assets/php/conexao.php';

$sql = "SELECT * FROM linha";
$resultado = $conexao->query($sql);

?>

<div class="conta">
    <div class="bloco_conta estilo_primario">
        <div class="ajuste_conta">
            <h1>Novo Trem</h1>
            <button class="btn_fechar" id="fechar_conta"><i class="fa-solid fa-x"></i></button>
        </div>
                
        <div class="bloco_conta estilo_secundario">
            <form action="../../assets/php/criar_trem.php" method='POST' enctype="multipart/form-data">
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

                    <input class="input_padrao estilo_secundario" type="text" name="prefixo_trem" placeholder="Prefixo | ex: BR 403" required>

                    <input class="input_padrao estilo_secundario" type="text" name="modelo_trem" placeholder="Modelo | ex: Siemens Velaro" required>

                    <input class="input_padrao estilo_secundario" type="number" name="ano_trem" placeholder="Ano de criação | ex: 2019" min="1800" max="2100" required >

                    <select class="input_padrao estilo_secundario" name="linhas" id="linhas">
                        
                        <option value="">Selecione uma linha</option>

                        <?php while ($linha = $resultado->fetch_assoc()):?>

                            <option value="<?= $linha['id_linha']?>"> <?= htmlspecialchars($linha['nome_linha'])?></option>

                        <?php endwhile;?>
                    </select>

                    <div class="opcoes_usuario">
                        <label class="opcao_usuario estilo_secundario">
                            <input type="radio" name="status_trem" value="ativo">
                            <span>Ativo</span>
                        </label>
                        <label class="opcao_usuario estilo_secundario">
                            <input type="radio" name="status_trem" value="manutencao">
                            <span>Manutenção</span>
                        </label>
                        <label class="opcao_usuario estilo_secundario">
                            <input type="radio" name="status_trem" value="parado">
                            <span>Parado</span>
                        </label>
                    </div>
                </div>

                    <button class="botao extensao_botao"><i class="fa-solid fa-plus"></i> Adicionar Trem</button>
            </form>             
        </div>
    </div>     
</div>