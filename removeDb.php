<?php
    include './conn.php';

    $selected_ids = $_POST['product_id'];
    
    
    
    /* Checking if the user has selected any option. */
    if(!empty($selected_ids)){
        $product = new ConcreteProduct;
        $product->removeFromDbById($conexao, $selected_ids);
    } else {
        $mensagem = "Select at least one option to delete";
        header('Location: ./index.php?mensagem=' .urlencode($mensagem));
        exit();
    }


    $conexao->close();
    
    header('Location: ./index.php');
    exit();
?>