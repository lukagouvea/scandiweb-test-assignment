<?php
    if (isset($_GET['mensagem'])) {
        
        echo "<script>window.onload = function() {alert('" . $_GET['mensagem'] . "')}</script>";
    }
?> 

<!DOCTYPE html>
<html>
<head>
	<title>Product Add</title>
	<link rel="stylesheet" href="style.css">
    <style>
        main{
            display: block;
        }
        input{
            position: absolute;
            left: 150px;
        }
        select{
            position: relative;
            left: 76px;
            width: 110px;
            text-align: center;
        }
        #dvdform, #bookform, #furnitureform{
            border: 1px solid;
            width: 300px;
            padding: 15px;
            padding-bottom: 0;

        }
        #size, #weight, #height, #width, #length{
            
            left: 150px;
        }
    </style>
    
</head>
<body>
	<header>
		<h1>Product Add</h1>
		<div>
			<button type="submit" form="product_form">Save</button>
			<button onclick="window.location.href='./index.php';">Cancel</button>
		</div>
        
	</header>
	
	<main>

        <!-- This is the form that the user will fill out to add a product to the database. 
        The form is divided into two parts. The first part is the form that is common to 
        all products. The second part is the form that is specific to the product type. 
        The user will select the product type from the dropdown menu. The function changeForm()
        is called when the user changes the value of the dropdown menu. The function then 
        checks the value of the dropdown menu and displays the appropriate form.-->
        <form id="product_form" action="insertDb.php" method="POST">
            
            <label for="sku">SKU:</label>
            <input type="text" id="sku" name="sku" required><br><br>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br><br>
            <label for="price">Price($):</label>
            <input type="text" id="price" name="price" 
                pattern="\d+(\.|,)?\d{0,2}" required><br><br>
            <label>Type Switcher: </label>
            <select id="productType" name="productType">
                <option value="dvd">DVD</option>
                <option value="book">Book</option>
                <option value="furniture">Furniture</option>
            </select><br><br>

            <!-- The form that is specific to the DVD product type. -->
            <div id="dvdform">
                
                <label for="size">Size (MB): </label>
                <input type="text" id="size" name="size" 
                    pattern="\d+(\.|,)?\d{0,2}" required><br><br>

                    <p style='text-align: center;'>Please, provide size in MB</p>
                
            </div>

            <!-- This is the form that is specific to the book product type. -->
            <div id="bookform" style="display:none;">
                
                <label for="weight">Weight (KG): </label>
                <input type="text" id="weight" name="weight" 
                    pattern="\d+(\.|,)?\d{0,2}"><br><br>

                <p style='text-align: center;'>Please, provide weight in Kg</p>

                
            </div>

            <!-- This is the form that is specific to the furniture product type. -->
            <div id="furnitureform" style="display:none;">
                
                <label for="height">Height (CM): </label>
                <input type="text" id="height" name="height" 
                    pattern="\d+(\.|,)?\d{0,2}"><br><br>
                <label for="width">Width (CM): </label>
                <input type="text" id="width" name="width"
                    pattern="\d+(\.|,)?\d{0,2}"><br><br>
                <label for="length">Length (CM): </label>
                <input type="text" id="length" name="length"
                    pattern="\d+(\.|,)?\d{0,2}"><br><br>

                    <p style='text-align: center;'>Please, provide dimensions in cm</p>
                

            </div>




            <!--
             * The function is called when the user changes the value of the dropdown menu. The
             * function then checks the value of the dropdown menu and displays the appropriate form.
             */-->
            <script type="text/javascript">
                document.getElementById("productType").
                addEventListener("change", changeForm);

                


                function changeForm() {
                    var x = document.getElementById("productType").value;
                    /* This is the code that is executed when the user selects the DVD product type.
                    The code displays the DVD form and sets the size input field to required. The
                    code also hides the book and furniture forms and sets the weight, height, width,
                    and length input fields to not required. */
                    if(x=="dvd"){
                        document.getElementById("dvdform").style.display="block"; 
                        document.getElementById("size").required = true;

                        document.getElementById("bookform").style.display="none";
                        document.getElementById("weight").required = false;

                        document.getElementById("furnitureform").style.display="none";
                        document.getElementById("height").required = false;
                        document.getElementById("width").required = false;
                        document.getElementById("length").required = false;

                    
                    }else if(x=="book"){
                        document.getElementById("dvdform").style.display="none";
                        document.getElementById("size").required = false;

                        document.getElementById("bookform").style.display="block";
                        document.getElementById("weight").required = true;

                        document.getElementById("furnitureform").style.display="none";
                        document.getElementById("height").required = false;
                        document.getElementById("width").required = false;
                        document.getElementById("length").required = false; 

                    }else if(x=="furniture"){
                        document.getElementById("dvdform").style.display="none"; 
                        document.getElementById("size").required = false;

                        document.getElementById("bookform").style.display="none";
                        document.getElementById("weight").required = false;

                        document.getElementById("furnitureform").style.display="block"; 
                        document.getElementById("height").required = true;
                        document.getElementById("width").required = true;
                        document.getElementById("length").required = true; 

                    }
                }
            </script>



        </form>




	</main>
	
	<footer>
		<p>Scadiweb Test Assignment</p>
	</footer>
</body>
</html>