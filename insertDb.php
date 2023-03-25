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
        echo "<!DOCTYPE html>
        <html>
        <head>
            <title>SKU field must be unique</title>
            <script>
                setTimeout(function() {
                    window.location.href = 'add-product.php';
                }, 5000);
            </script>
        </head>
        <body>
            <p> SKU field must be unique</p>
            <p>Redirecting to Product Add page.</p>
        </body>
        </html>";
        
    }
    


?>
