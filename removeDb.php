<?php
    include './conn.php';
    
    
    
    
    $id = array();
    $i = 0;

    $query = "SELECT idProduct FROM tblproduct ORDER BY idProduct";

    $result = $conexao->query($query);

    
                
    /* Checking if the query returned any results. */
    if ($result->num_rows > 0) {
        /* Looping through the results of the query and pushing the id of each product into the array. */
        while ($row = $result->fetch_assoc()){
            array_push($id, $row['idProduct']);
        }
        
    }
    else{
        echo "0 results";
    }

    /* Looping through the array of ids. */
    while ($i <= count($id)){

        /* Checking if the checkbox associated to the product exists. */
        if(isset($_POST["$id[$i]"])){
            
            $sql = "delete from tblproduct where idProduct = " .$id[$i];

            /* Checking if the query was successful. */
            if ($conexao->query($sql) === TRUE) {
                echo "removed with succes";
            } else {
                echo "ERROR: " . $conexao.$error;
            }
        }
        $i = $i + 1;
        
    }
    $conexao->close();
    
    header('Location: ./index.php');
    exit();
    
    
?>
