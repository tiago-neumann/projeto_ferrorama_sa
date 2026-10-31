<?php

session_start();

require "../../assets/php/conexao.php";

$sql = "SELECT id_trem, prefixo_trem, modelo_trem FROM trem";
$resultado = $conexao->query($sql);

?>

<div class="conta">
    <div class="bloco_conta estilo_primario">
        <div class="ajuste_conta">
            <h1>Criar sensor</h1>
            <button class="btn_fechar" id="fechar_conta"><i class="fa-solid fa-x"></i></button>
        </div>

        <div class="bloco_conta estilo_secundario">

            <form action="../../assets/php/criar_sensor.php" method="POST">
                <div class="separacao">

                    <input class="input_padrao estilo_secundario" type="text" name="codigo_sensor" placeholder="Código do sensor" required>

                    <input class="input_padrao estilo_secundario" type="text" name="tipo_sensor" placeholder="Tipo do sensor" required>

                    <input class="input_padrao estilo_secundario" type="text" name="unidade_sensor" placeholder="Unidades do sensor" required>

                    <select class="input_padrao estilo_secundario" name="trem_sensor" id="trens">
                        
                        <option value="">Selecione um trem</option>

                        <?php while ($trem = $resultado->fetch_assoc()):?>

                            <option value="<?= $trem['id_trem']?>"> <?= htmlspecialchars($trem['prefixo_trem']), " / ", htmlspecialchars($trem['modelo_trem']) ?></option>

                        <?php endwhile;?>
                    </select>

                    <p id="erro_sensor"></p>

                </div>

                <button type="submit" class="botao extensao_botao"><i class="fa-solid fa-plus"></i> Criar conta</button>
            </form>
        </div>
    </div>
</div>