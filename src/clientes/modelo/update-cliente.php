<?php

    include ( '../../banco/conexao.php' );

    if ( $conexao ) {

        $requestData = $_REQUEST ;

        if ( empty ( $requestData [ 'nome' ]) || vazio ( $requestData [ 'ativo' ])) {
            $dados = array (
                "tipo" => "info" ,
                "mensagem" => "Existe (m) campo (s) obrigatório (s) em branco."
            );
        } else {
            $id = isset ( $requestData [ 'idcliente' ])? $requestData [ 'idcliente' ]: '' ;
            

            $date = date_create_from_format ('d/m/Y H:i:s', $requestData [ 'dataagora' ]);
            $requestData [ 'dataagora' ] = date_format ( $date ,'Y-m-d H:i:s' );

            $sql = "UPDATE clientes SET nome = '$requestData[nome]', ativo = '$requestData[ativo]', email = '$requestData[email]', telefone = '$requestData[telefone]',
             datamodificacao = '$requestData[dataagora]' WHERE idcliente = $id" ;

            $resultado = mysqli_query ( $conexao , $sql );

            if ( $resultado ) {
                $dados = array (
                    "tipo" => "sucesso" ,
                    "mensagem" => "Cliente alterada com sucesso."
                );
            } else {
                $dados = array (
                    "tipo" => "erro" ,
                    "mensagem" => mysqli_error ( $conexao ) // "Não foi possível alterar clientes."
                );
            }
        }

        mysqli_close ( $conexao );

    } else {
        $dados = array (
            "tipo" => "info" ,
            "mensagem" => "Ops ... não foi possível conectar ao banco de dados"
        );
    }

   echo  json_encode ( $dados , JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );