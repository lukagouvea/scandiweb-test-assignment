

<?php
    define('HOST', 'localhost');
    DEFINE('USUARIO', 'root');
    define('PASSWORD', '');
    define('DB', 'product');
    
    $conexao = new mysqli(HOST, USUARIO, PASSWORD, DB);


    /**
     * Summary of Product
     */
    abstract class Product{
        private $idProduct;
        private $SKU;
        private $name;
        private $price;
        


    
        /**
         * Summary of setInfo
         * @param mixed $info
         * @return void
         */
        /**
         * It sets the values of the object's properties to the values of the array's keys.
         * 
         * 
         */
        public function setInfo($info){
            if(isset($info['idProduct'])){
                $this->setIdProduct($info['idProduct']);
            }
            if(isset($info['SKU'])){
                $this->setSKU($info['SKU']);
            } else if(isset($info['sku'])){
                $this->setSKU($info['sku']);
            }

            $this->setName($info['name']);
            $this->setPrice($info['price']);
        }

        
        
        /**
         * Summary of validSKU
         * @param mixed $conexao
         * @return bool
         */
        /**
         * It checks if the SKU is already in the database.
         */
        public function validSKU($conexao){

            /* Checking if the SKU is empty. */
            $valor = $this->getSKU();
            

            
            
            /* SQL Query to check if the SKU is already in the database */
            $sql = "SELECT * FROM tblproduct WHERE SKU = '$valor'";
            $result = mysqli_query($conexao, $sql);

            
            
            /* Checking if the SKU is already in the database. */
            if (mysqli_num_rows($result) > 0) {
                // O valor já existe no banco de dados
                return false;
            } else {
                return true;
            }
            
        }


        public function removeFromDbById($id, $conexao){
            $sql = "delete from tblproduct where idProduct = " .$id;

            if ($conexao->query($sql) === TRUE) {
                echo "removed with succes";
            } else {
                
            }
        }

        



        /**
         * Summary of renderInfo
         * @return void
         */
        /**
         * It's a function that renders the product information in a table.
         */
        public function renderInfo(){
            
        }


        


        /**
         * @return mixed
         */
        public function getSKU() {
            return $this->SKU;
        }

        /**
         * @param mixed $SKU 
         * @return self
         */
        public function setSKU($SKU): self {
            $this->SKU = $SKU;
            return $this;
        }

        /**
         * @return mixed
         */
        public function getName() {
            return $this->name;
        }
        
        /**
         * @param mixed $name 
         * @return self
         */
        public function setName($name): self {
            $this->name = $name;
            return $this;
        }

        /**
         * @return mixed
         */
        public function getPrice() {
            return $this->price;
        }
        
        /**
         * @param mixed $price 
         * @return self
         */
        public function setPrice($price): self {
            $this->price = $price;
            return $this;
        }
    
        /**
         * @return mixed
         */
        public function getIdProduct() {
            return $this->idProduct;
        }
        
        /**
         * @param mixed $idProduct 
         * @return self
         */
        public function setIdProduct($idProduct): self {
            $this->idProduct = $idProduct;
            return $this;
        }
    }

    /* It extends the Product class. */
    /**
     * Summary of DVD
     */
    class DVD extends Product{
        private $size;

        /**
         * Summary of setInfo
         * @param mixed $info
         * @return void
         */
        /**
         * It sets the size of the object
         * 
         * 
         */
        public function setInfo($info){
            parent::setInfo($info);
            $this->setSize($info['size']);
        }

        
        
        /**
         * Summary of renderInfo
         * @return void
         */
        /**
         * The function is a method of the class "File" and it is overriding the renderInfo() method of
         * the parent class "Item".
         */
        public function renderInfo(){
            

            echo ("
                    
                <div class='box'>
                    <div id='chkbx'>
                        <input class='delete-checkbox' 
                        type='checkbox' 
                        name='product_id_type[]'
                        value='".$this->getIdProduct().", DVD'>
                    </div>
                    ".$this->getSKU()."<br>
                    ".$this->getName()."<br>
                    ".number_format($this->getPrice(), 2)." $<br>
                    Size: ".$this->getSize()."MB

                </div>
            ");
        }

        /**
         * Summary of insertInfoQuery
         * @return string
         */
        /**
         * It takes the values from the object and return a SQL query to insert into DB.
         * 
         *
         */
        public function insertInfo($conexao){
            
            $query = "INSERT INTO tblproduct (SKU, name, price, size, type) VALUES ('".
                $this->getSKU()."', '".$this->getName()."', '"
                .$this->getPrice()."', '".$this->getSize()."', 'dvd')";

            if ($conexao->query($query) === TRUE) {
                header('Location: ./index.php');
                exit();
            } else {
                echo "ERROR: " . $conexao;
                
            }
            
        }

        

        

        /**
         * @return mixed
         */
        
        public function getSize() {
            return $this->size;
        }
        
        /**
         * @param mixed $size 
         * @return self
         */
        public function setSize($size): self {
            $this->size = $size;
            return $this;
        }
        }
        /**
         * Summary of Book
         */
        class Book extends Product{
            private $weight;

        /**
         * Summary of setInfo
         * @param mixed $info
         * @return void
         */
        /**
         * The function sets the weight of the item
         * 
         *
         */
        public function setInfo($info){
            parent::setInfo($info);
            $this->setWeight($info['weight']);
        }

        

        /**
         * Summary of renderInfo
         * @return void
         */
        
        /*
        // Render information of the book 
        */
        public function renderInfo(){
            

            echo ("
            
                <div class='box'>
                    <div id='chkbx'>
                        <input class='delete-checkbox' 
                        type='checkbox' 
                        name='product_id_type[]'
                        value='".$this->getIdProduct().", Book'>
                    </div>
                    ".$this->getSKU()."<br>
                    ".$this->getName()."<br>
                    ".number_format($this->getPrice(), 2)." $<br>
                    Weight: ".$this->getWeight()." Kg
                  
                </div>
            ");
        }


        /**
         * Summary of insertInfoQuery
         * @return void
         */
        /**
         * It takes the values from the object and return a SQL query to insert into DB.
         * 
         * 
         */
        public function insertInfo($conexao){
            
            $query = "INSERT INTO tblproduct (SKU, name, price, weight, type) VALUES ('"
            .$this->getSKU()."', '".$this->getName()."', '"
            .$this->getPrice()."', '".$this->getWeight()."', 'book')";
            
            if ($conexao->query($query) === TRUE) {
                header('Location: ./index.php');
                exit();
            } else {
                echo "ERROR: " . $conexao;
                
            }
            
            
        }
        
        /**
         * @return mixed
         */
        public function getWeight() {
            return $this->weight;
        }
        
        /**
         * @param mixed $weight 
         * @return self
         */
        public function setWeight($weight): self {
            $this->weight = $weight;
            return $this;
        }
    }
    /**
     * Summary of Furniture
     */
    class Furniture extends Product{
        private $height;
        private $length;
        private $width;


        /**
         * Summary of setInfo
         * @param mixed $info
         * @return void
         */
        
        /**
         * The function sets the height, length, and width of the object
         * 
         * 
         */
        public function setInfo($info){
            parent::setInfo($info);
            $this->setHeight($info['height']);
            $this->setLength($info['length']);
            $this->setWidth($info['width']);
        }

        
        /**
         * Summary of renderInfo
         * @return void
         */
        public function renderInfo(){
            

            echo ("
                <div class='box'>
                    <div id='chkbx'>
                        <input class='delete-checkbox' 
                        type='checkbox' 
                        name='product_id_type[]'
                        value='".$this->getIdProduct().", Furniture'>
                    </div>
                    ".$this->getSKU()."<br>
                    ".$this->getName()."<br>
                    ".number_format($this->getPrice(), 2)." $<br>
                    Dimension: ".$this->getHeight()."x"
                    .$this->getWidth()."x"
                    .$this->getLength()."
                  
                </div>
            ");
        }

        /**
         * Summary of insertInfoQuery
         * @return void
         */
        public function insertInfo($conexao){
            
            $query = "INSERT INTO tblproduct 
            (SKU, name, price, height, width, length, type) VALUES 
            ('".$this->getSKU()."', '".$this->getName()."', '"
            .$this->getPrice()."', '".$this->getHeight()."', '"
            .$this->getWidth()."', '".$this->getLength()."', 'furniture')";

            if ($conexao->query($query) === TRUE) {
                header('Location: ./index.php');
                exit();
            } else {
                echo "ERROR: " . $conexao;
                
            }


            
        }
        

        /**
         * @return mixed
         */
        public function getHeight() {
            return $this->height;
        }

        /**
         * @param mixed $height 
         * @return self
         */
        public function setHeight($height): self {
            $this->height = $height;
            return $this;
        }

        /**
         * @return mixed
         */
        public function getLength() {
            return $this->length;
        }
        
        /**
         * @param mixed $length 
         * @return self
         */
        public function setLength($length): self {
            $this->length = $length;
            return $this;
        }

        /**
         * @return mixed
         */
        public function getWidth() {
            return $this->width;
        }
        
        /**
         * @param mixed $width 
         * @return self
         */
        public function setWidth($width): self {
            $this->width = $width;
            return $this;
        }
    }
    
    
?>


