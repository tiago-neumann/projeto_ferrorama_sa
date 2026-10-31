<div class="conta">
    <div class="bloco_conta estilo_primario">
        <div class="ajuste_conta">
            <h1>Criar usuário</h1>
            <button class="btn_fechar" id="fechar_conta"><i class="fa-solid fa-x"></i></button>
        </div>

        <div class="bloco_conta estilo_secundario">

            <form action="../../assets/php/criar_usuario.php" method="POST">
                <div class="separacao">

                    <input class="input_padrao estilo_secundario" type="text" name="nome_usuario" placeholder="Nome" required>

                    <input class="input_padrao estilo_secundario" type="email" name="email_usuario" placeholder="Email" required>

                    <input class="input_padrao estilo_secundario" type="password" name="senha_usuario" placeholder="Senha" required>

                    <div class="opcoes_usuario">

                        <label class="opcao_usuario estilo_secundario">
                            <input type="radio" name="tipo_usuario" value="usuario" checked required>
                            <span>Usuário</span>
                        </label>

                        <label class="opcao_usuario estilo_secundario">
                            <input type="radio" name="tipo_usuario" value="admin" required>
                            <span>Admin</span>
                        </label>
                    </div>
                </div>

                <button type="submit" class="botao extensao_botao"><i class="fa-solid fa-plus"></i> Criar conta</button>
            </form>
        </div>
    </div>
</div>