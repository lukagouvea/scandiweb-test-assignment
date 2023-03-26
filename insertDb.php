<?php
    include './conn.php';

    /* Creating a new object of the class that was passed in the form. */
    $newproduct = new $_POST['productType'];
    $newproduct->setInfoPOST($_POST);

    /* Checking if the SKU is unique, if it is, it will insert the product into the database. */
    if($newproduct->validInfo($conexao)){
        
        $query = $newproduct->insertInfoQuery();

        if ($conexao->query($query) === TRUE) {
            header('Location: ./index.php');
            exit();
        } else {
            echo "ERROR: " . $conexao.$error;
            
        }
    }else{

        $mensagem = "SKU must be unique";
        header('Location: ./add-product.php?mensagem=' .urlencode($mensagem));
        exit();

        
    }
    
    $conexao->close();
    


?>

