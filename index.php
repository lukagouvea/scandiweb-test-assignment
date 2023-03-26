<?php
    include './conn.php';

    if (isset($_GET['mensagem'])) {
        
        echo "<script>window.onload = function() {alert('" . $_GET['mensagem'] . "')}
              </script>";
    }
    
?>

<!DOCTYPE html>
<html>
<head>
	<title>Product List</title>
	<link rel="stylesheet" href="style.css">
    <style>
        

        #deleteform{
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-gap: 20px;
        }
        .box{

            padding-bottom: 30px;
            margin: 5px;
            border: 1px solid #333;
        }
        .delete-checkbox{
            height: 15px;
            width: 15px; 
            
            
        }
        
        #chkbx{
            position: relative;
            float: left;
            width: 25px;
            left:-20px;
            top: -20px;
        }
        
        
    </style>
</head>
<body>
	<header>
		<h1>Product List</h1>
		<div>
			<button value="ADD" onclick="window.location.href='./add-product.php';">
                ADD
            </button>
			<button value="MASS DELETE" type="submit" 
            form="deleteform" id="delete-product-btn" onclick="return verifyCheckbox()">
                MASS DELETE
            </button>
		</div>
        
	</header>
	
	<main>
        <form id="deleteform" action="removeDb.php" method="POST">
            
            <?php

                /* Selecting all the data from the table tblProduct and ordering it 
                by the idProduct. */
                $query = "SELECT * FROM tblproduct ORDER BY idProduct";


                /* Executing the query and storing the result in the variable . */
                $result = $conexao->query($query);
                
                /* Checking if the query returned any results. */
                if ($result->num_rows > 0) {
                    
                    /* Fetching the results from the database and rendering them
                     on the page. */
                    while ($row = $result->fetch_assoc()) {
                        
                        $newProduct = new $row['type'];
                        $newProduct->setInfo($row);
                        $newProduct->renderInfo();
                        
                    }
                    

                    $conexao->close();
                }
                

            ?>
        </form>
        
        <script>
            function verifyCheckbox() {
                var checkboxes = document.getElementsByClassName('delete-checkbox');

                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].checked) {
                    return true; //at least one checkbox checked
                    }
                }

                alert("Select at least one option to delete"); // no checkboxes checked
                return false; 
            }
        </script>
        
	</main>
	
	<footer>
		<p>Scadiweb Test Assignment</p>
	</footer>
</body>
</html>