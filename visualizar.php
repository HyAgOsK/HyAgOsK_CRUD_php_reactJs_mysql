<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    include_once "conexao.php";

    //exemplo ver o valor do ID 1
    //testando no front end
    
    
    // entrada dinâmica forcando que seja entrada intera
    // a partir de FILTER_SANITIZE_NUMBER_INT
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    
    $response = "";

    $query_produtos = "SELECT id, titulo, descricao FROM produtos WHERE id=:id";
    $result_produto = $conn->prepare($query_produtos);
    $result_produto->bindParam(':id', $id);
    $result_produto->execute();
    //foi executado com sucesso e se possui algum produto
    if($result_produto AND ($result_produto->rowCount()!=0)){
        // FETCH_ASSOC -> É usado para usar o mesmo nome da
        //coluna que declaramos no mysql
        $row_produto = $result_produto->fetch(PDO::FETCH_ASSOC);
        extract($row_produto);
        $produto = [
            'id' => $id,
            'titulo' => $titulo,
            'descricao' => $descricao
        ];

        $response = [
            "erro" => false,
            "produto" => $produto
        ];
    }else{
        $response = [
            "erro" => true,
            "produto" => $produto
        ];
    }

    http_response_code(200);
    echo json_encode($response);

?>