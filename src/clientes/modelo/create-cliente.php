<?php

include('../../banco/conexao.php');

 if(!$conexao){
     $dados = array(
         'tipo' => 'info',
         'mensagem' => 'OBS, não foi possivel obter uma conexao com o banco de dados, tente mais tarde.'
        );
    }else{

         $requestaData = $_REQUEST;

    
        if(empty($requestData['nome']) || empty($requestaData['ativo']) ){
            $dados = array(
                'tipo' => 'info',
                'mensagem' => 'Existe(m) campo(s) obrigatorio(s) vazio(s)'
            );
    } else {

        $date = date_create_from_format('d/m/Y H:i:s', $requestaData['dataagora']); $requestaData['dataagora'] = date_format($date, 'Y-m-d H:i:s');

        $sqlComando = "INSERT INTO CLIENTES (nome, email, telefone, ativo, datacriacao, datamodificacao)
        VALUES('$requestaData[nome]', '$requestaData[email]', '$requestaData[telefone]', '$requestaData[ativo]', '$requestaData[dataagora]',
        '$requestaData[dataagora]')";

        $resultado = mysqli_query($conexao, $sqlClientes);

        if($resultado){
            $dados = array(
                'tipo' => 'success',
                'mensagem' => 'Cliente criada(o) com sucesso'
            }else{
                $dados = array(
                    'tipo' => 'error',
                    'mensagem' => 'Não foi possivel criar o cliente' 
            }
        }
     mysqli_close($conexao)
    }
};


echo json_encode($dados, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
 