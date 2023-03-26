<?php
    include './conn.php';
    
    
    
    

    $id_type_selected = $_POST['product_id_type'];
    var_dump($id_type_selected);

    if (!empty($_POST['product_id_type'])) {
        foreach ($_POST['product_id_type'] as $selected_option) {
          $option_values = explode(', ', $selected_option);
          $id = $option_values[0];
          $type = $option_values[1];
          $product = new $type;
          $product->removeFromDbById($id, $conexao);
        }
    } else {
    // nenhuma opção foi selecionada
    }

    $conexao->close();
    
    header('Location: ./index.php');
    exit();

    
?>
