<?php
    include './conn.php';

    $id_selected = $_POST['product_id'];
    
    
    
    /* Checking if the user has selected any option. */
    if(!empty($id_selected)){
        $product = new ConcreteProduct;
        $product->removeFromDbById($conexao, $id_selected);
    } else {
        $mensagem = "Select at least one option to delete";
        header('Location: ./index.php?mensagem=' .urlencode($mensagem));
        exit();
    }


    $conexao->close();
    
    header('Location: ./index.php');
    exit();
?>