<?php
    include ( '../../banco/conexao.php' );
    if ( $conexao ) {
        $requestData = $_REQUEST ;
        $id = isset ( $requestData [ 'idcliente' ])? $requestData [ 'idcliente' ]: '' ;

        $sql = "SELECT idcliente, nome, ativo, email, telefone DATE_FORMAT (datacriacao, '% d /% m /% Y% H:% i:% s') como datacriacao,
         DATE_FORMAT (datamodificacao, '% d /% m /% Y % H:% i:% s ')
         como especificação de dados FROM clientes WHERE idcliente = $id " ;

        $resultado = mysqli_query ( $conexao , $sql );

        if ( $resultado && mysqli_num_rows ($resultado )> 0) {
            while ( $linha = mysqli_fetch_assoc ($resultado )) {
                $dadosClientes = array_map ( 'utf8_encode' ,$linha );
            }
            $dados = array ( 
                "tipo" => "success",
                "mensagem" => "",
                "dados" => $dadosClientes );
        }else{
            $dados = array ( 
                "tipo" => "error",
                "mensagem" => "Não é possível localizar cliente.",
                "dados" => array ());
        }
        mysqli_close ( $conexao );
    }else{
        $dados = array ( 
              "tipo" => "info",
              "mensagem" => "Não é possível acessar o banco de dados",
              "dados" => array ());
    }
echo  json_encode ( $dados , JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
