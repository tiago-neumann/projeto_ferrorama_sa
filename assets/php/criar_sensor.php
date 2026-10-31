<?php

session_start();

require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $erro = '';

    $codigo = $_POST['codigo_sensor'];
    $tipo = trim($_POST['tipo_sensor']);
    $unidade = trim($_POST['unidade_sensor']);
    $trem = filter_input(INPUT_POST, 'trem_sensor', FILTER_VALIDATE_INT);

    if($codigo === '' || $tipo === '' || $unidade === '' || $trem === false || $trem === null){

        $erro = "Preencha todos os campos!";

    } else {

        $sql_verifica = "SELECT id_sensor FROM sensor WHERE codigo_sensor = ?";
        $stmt_verifica = $conexao->prepare($sql_verifica);

        $stmt_verifica->bind_param("s", $codigo);
        $stmt_verifica->execute();

        $resultado = $stmt_verifica->get_result();

        if($resultado->num_rows > 0){

            $stmt_verifica->close();
            $erro = "Este código já está cadastrado!";

        } else {

            $sql = "INSERT INTO sensor (codigo_sensor, tipo_sensor, unidade_sensor, id_trem) VALUES (?, ?, ?, ?)";

            $stmt = $conexao->prepare($sql);
            $stmt->bind_param("sssi", $codigo, $tipo, $unidade, $trem);
            
            if($stmt->execute()){

                header('Location: ../../pages/tela_sensores/tela_sensores.php?cadastro=sucesso');
                exit;

            } else {

                $stmt->close();

                if($stmt->errno === 1062){

                    $erro = "Este código já esta sendo utilizado!";

                } else {

                    $erro = "Erro ao realizar a criação do sensor!";

                }
            }
        }
    }
}

?>