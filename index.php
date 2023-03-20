<?php


    //cabecalhos obrigatórios 
    //quem pode fazer requisições. sendo que todos podem
    header("Access-Control-Allow-Origin: *");
    //banco de dados, e os tipos de dados serem lidos
    //pelos caracteres especiais, assim é preciso tratar
    //os dados para json, do banco de dados e criar um arquivo
    //json para que possa ser lido
    header("Content-Type: application/json; charset=UTF-8");

    include_once "conexao.php";
    
    //selecionando id, titulo e descricao, da tabela produtos criada
    //no mysql, assim ordenando ela também
    //Desc os utlimos registros traga por primeiro
    $query_produtos =  "SELECT id, titulo, descricao FROM produtos ORDER BY id DESC";
    $result_produtos = $conn->prepare($query_produtos);
    $result_produtos->execute();
    
    // $result_produtos->rowCount()!= 0
    // significa que foi encontrado algum registro
    //$result_produtos retorna true se conseguir executar 
    // a tabela
    if($result_produtos AND $result_produtos->rowCount()!= 0){
        while($row_produto = $result_produtos->fetch(PDO::FETCH_ASSOC)){
            //var_dump($row_produto);
            //lendo cada arrey criado como 
            //cada uma das linhas, sendo o ultimo em primeiro
           
           
            extract($row_produto);
            //com extract posso usar o mesmo nome da colua como variavel
            $lista_produtos["records"][$id] = [
                'id' => $id,
                'titulo' => $titulo,
                'descricao' => $descricao
            ];
            //aqui então sera repedito enquyanto tiver valores de linha id
               
        }
        //resposta com status 200 OK
        http_response_code(200);
        //retornar os valores em JSon das listas em produtos
        //usando encode, retornando com echo
        echo json_encode($lista_produtos);
    }

    //em seguida foi instalado o Insomnia
    //faz requisições 

?>