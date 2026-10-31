<?php

session_start();

?>

<div class="conta">
    <div class="bloco_conta estilo_primario">
        <div class="ajuste_conta">
            <h1>Usuário</h1>
            <button class="btn_fechar" id="fechar_conta"><i class="fa-solid fa-x"></i></button>
        </div>
                
        <div class="bloco_conta estilo_secundario">
            <ul>
                <li class="estilo_secundario"><strong>Nome:</strong> <?php echo $_SESSION['nome_usuario']?> </li>
                <li class="estilo_secundario"><strong>Email:</strong> <?php echo $_SESSION['email_usuario']?> </li>
                <li class="estilo_secundario"><strong>Autorização:</strong> <?php echo $_SESSION['tipo_usuario']?> </li>
            </ul>

            <div class="ajuste_botoes">
                <form action="../../assets/php/logout.php" method='POST'>
                    <button class="botao extensao_botao"><i class="fa-solid fa-arrow-up-right-from-square"></i> Sair da sessão</button>
                </form>
                <form action="../../assets/php/excluir_conta.php" method='POST'>
                    <button class="botao extensao_botao"><i class="fa-solid fa-x"></i> Excluír conta</button>
                </form>
            </div>    
        </div>
    </div>        
</div>