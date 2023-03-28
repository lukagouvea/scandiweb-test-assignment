<?php
    include './conn.php';

    /* Creating a new object of the class that was passed in the form. */
    $newproduct = new $_POST['productType'];
    $newproduct->setInfo($_POST);

    /* Checking if the SKU is unique, if it is, it will insert the product into the 
    database. */
    if($newproduct->validSKU($conexao)){
               
        $newproduct->insertInfo($conexao);
        
    }else{
        $conexao = null;
        $mensagem = "SKU must be unique";
        header('Location: ./add-product.php?mensagem=' .urlencode($mensagem));
        exit();
        
    }
    
    $conexao = null;
    


?>

