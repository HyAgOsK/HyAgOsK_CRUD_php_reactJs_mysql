<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: *");
    header("Access-Control-Allow-Methods: GET,PUT,POST,DELETE");
    
    include_once "conexao.php";

    //conteúdo que vem do input dos dados
    $response_json = file_get_contents("php://input");
    //ler o valor de json para natural
    $dados = json_decode($response_json, true);
  
    //vazio 
    if($dados){
        $query_produto = "INSERT INTO produtos (titulo,descricao) VALUES (:titulo,:descricao)";
        $cad_produto = $conn->prepare($query_produto);
        $cad_produto->bindParam(':titulo',$dados['produto']['titulo'], PDO::PARAM_STR);
        $cad_produto->bindParam(':descricao',$dados['produto']['descricao'], PDO::PARAM_STR);
        $cad_produto->execute();
        //true quer dizer que foi cadastrado com sucesso
        //36.21
        if ($cad_produto->rowCount()){
            $response = [
                "erro" => false,
                "mensagem" => "Produto ou Ordem de serviço cadastrada!!"
            ];

        }else{      
            $response = [
                "erro" => true,
                "mensagem" => "Produto ou Ordem de serviço não cadastrada!!"
            ];
        }
    }else{
        $response = [
            "erro" => true,
            "mensagem" => "Produto ou Ordem de serviço não cadastrada!!"
        ];
    }
    http_response_code(200);
    echo json_encode($response);


    /*do front end os dados de 
    entrada vem de um formato JSON que fica assim abaixo
    _____________________________________________________
    {
        "produto":    {
        "titulo":"Teclado ... ",
        "descricao":"O Teclado possui ..."
        }
    }____________________________________________________
    */

?>