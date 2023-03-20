<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    include_once "conexao.php";

    //receber o valor do id atravez de uma url 
    $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

    $response = "";
    $response2 = "";

    $query_produtos_verificando = "SELECT id, titulo, descricao FROM produtos WHERE id=:id";
    $result_produto_verificando = $conn->prepare($query_produtos_verificando);
    $result_produto_verificando->bindParam(':id', $id);
    $result_produto_verificando->execute();
    if($result_produto_verificando AND ($result_produto_verificando->rowCount()!=0)){
        $row_produto_verificando = $result_produto_verificando->fetch(PDO::FETCH_ASSOC);
        extract($row_produto_verificando);
        $produto_verificado = [
            'id' => $id,
            'titulo' => $titulo,
            'descricao' => $descricao
        ]; 
        $response2 = [
            "erro" => false,
            "produto" => $produto_verificado
        ];
    }else{
        $response2 = [
            "erro" => true,
            "produto" => $produto_verificado
        ]; 
    }

    $query_produto = "DELETE FROM produtos WHERE id=:id LIMIT 1";
    $delete_produto = $conn->prepare($query_produto);
    $delete_produto->bindParam(':id',$id,PDO::PARAM_INT);
    
    if($delete_produto->execute()){
        $response = [
            "erro" => false, 
            "mensagem" => 'Produto =>'. strtoupper($id).'| Título => ' .strtoupper($titulo). '| Descrição =>'. strtoupper($descricao) .' foi apagado com sucesso'
        ];
    }else{
        $response = [
            "erro" => true, 
            "mensagem" => "Produto $id não foi apagado"
        ];
    }


    http_response_code(200); 
    echo json_encode($response);
?>