<?php
    if (isset($_GET['mensagem'])) {
        
        echo "<script>window.onload = function() {alert('" . $_GET['mensagem'] . "')}
              </script>";
    }
?> 

<!-- Setting classes that correspond to each type of product then use the methodo setForm
to change the form to the desired type -->
<script>

    class DVD {
        setForm(){
            document.getElementById("dvdform").style.display="block"; 
            document.getElementById("size").required = true;

            document.getElementById("bookform").style.display="none";
            document.getElementById("weight").required = false;

            document.getElementById("furnitureform").style.display="none";
            document.getElementById("height").required = false;
            document.getElementById("length").required = false;
            document.getElementById("width").required = false;
        }
    }

    class Book{
        setForm(){
            document.getElementById("dvdform").style.display="none";
            document.getElementById("size").required = false;

            document.getElementById("bookform").style.display="block";
            document.getElementById("weight").required = true;

            document.getElementById("furnitureform").style.display="none";
            document.getElementById("height").required = false;
            document.getElementById("width").required = false;
            document.getElementById("length").required = false; 
        }
    }

    class Furniture{
        setForm(){
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

    /* Creating an object that has the keys dvd, book, and furniture. The values of the
    keys are the classes DVD, Book, and Furniture. */
    const productClasses = {
        dvd: DVD,
        book: Book,
        furniture: Furniture
    };


</script>

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
            left: 170px;
        }
        select{
            position: relative;
            left: 86px;
            width: 110px;
            height: 21px;
            text-align: center;
        }
        #dvdform, #bookform, #furnitureform{
            border: 1px solid;
            width: 300px;
            padding: 15px;
            padding-bottom: 0;
            border-radius: 5px;

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
            <input type="text" id="sku" name="SKU" required><br><br>

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




            
            <!-- This script is responsible for changing the form that is displayed to the user when the
            user changes the value of the dropdown menu. -->
            <script>

                /* This is an event listener that is listening for the change event. When the change
                event is triggered, the function changeForm() is called. */
                document.getElementById("productType").
                addEventListener("change", changeForm);

                
                /**
                 * When the user changes the value of the dropdown, the value of the dropdown is used
                 * to create a new instance of the class that matches the value of the dropdown, and
                 * then the setForm function of that class is called.
                 */
                function changeForm() {

                    let type = document.getElementById("productType").value;

                    let product = new productClasses[type];
                    product.setForm();
                    
                }
            </script>



        </form>

	</main>
	
	<footer>
		<p>Scandiweb Test Assignment</p>
	</footer>
</body>
</html>