<?php
    include './conn.php';

    $id_type_selected = $_POST['product_id_type'];

    /* Checking if the user has selected any option. */
    if (!empty($id_type_selected)) {
        /* Iterating over the array of selected options. */
        foreach ($id_type_selected as $selected_option) {
            /* Splitting the string into an array. */
            $option_values = explode(', ', $selected_option);
            $id = $option_values[0];
            $type = $option_values[1];

            /* Creating a new object of the type that was selected in the form. */
            $product = new $type;
            $product->removeFromDbById($conexao, $id);
        }
    } else {
        $mensagem = "Select at least one option to delete";
        header('Location: ./index.php?mensagem=' .urlencode($mensagem));
        exit();
    }

    $conexao->close();
    
    header('Location: ./index.php');
    exit();
?>