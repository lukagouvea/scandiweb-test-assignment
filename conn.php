<?php
    DEFINE('HOST', 'localhost');
    DEFINE('USUARIO', 'root');
    DEFINE('PASSWORD', '');
    DEFINE('DB', 'product');
    
    $conexao = new mysqli(HOST, USUARIO, PASSWORD, DB);
 
    /**
     * Summary of Product
     */
    abstract class Product{
        /**
         * Summary of idProduct
         * @var
         */
        private $idProduct;
        /**
         * Summary of SKU
         * @var
         */
        private $SKU;
        /**
         * Summary of name
         * @var
         */
        private $name;
        /**
         * Summary of price
         * @var
         */
        private $price;

        


    
        /**
         * Summary of setInfo
         * @param mixed $info
         * @return void
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
        public function validSKU($conexao){

            /* Checking if the SKU is empty. */
            $sku = $this->getSKU();
            
            /* SQL Query to check if the SKU is already in the database */
            $query = "SELECT * FROM tblproduct WHERE SKU = '$sku'";
            $result = mysqli_query($conexao, $query);

            /* Checking if the SKU is already in the database. */
            if (mysqli_num_rows($result) > 0) {
                // SKU is already in the database
                return false;
            } else {
                return true;
            }
            
        }


        /**
         * Summary of removeFromDbById
         * @param mixed $id
         * @param mixed $conexao
         * @return void
         */
        public function removeFromDbById($conexao, $ids){

            $query = "DELETE FROM tblproduct WHERE idProduct IN 
                (".implode(',', array_fill(0, count($ids), '?')).")";
            
            $stmt = $conexao->prepare($query);

            $stmt->bind_param(str_repeat('i', count($ids)), ...$ids);

            if ($stmt->execute() === TRUE) {
                header('Location: ./index.php');
                exit();
            } else {
                echo "ERROR: " . $conexao;
                
            }

            
        }

        /**
         * @return mixed
         */
        public function getSKU() {
            return $this->SKU;
        }

        /**
         * @param mixed $SKU 
         * 
         */
        public function setSKU($SKU): self {

            if($SKU == ''){
                
                $mensagem = "SKU field must not be empty";
                header('Location: ./add-product.php?mensagem=' .urlencode($mensagem));
                exit();
            ;
            }else{
                $this->SKU = $SKU;
                return $this;
            }
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
            if($name == ''){
                
                $mensagem = "Name field must not be empty";
                header('Location: ./add-product.php?mensagem=' .urlencode($mensagem));
                exit();
            ;
            }else{
                $this->name = $name;
                return $this;
            }
            
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
            if($price == ''){
                
                $mensagem = "Price field must not be empty";
                header('Location: ./add-product.php?mensagem=' .urlencode($mensagem));
                exit();
            ;
            }elseif(!filter_var($price, FILTER_VALIDATE_FLOAT)){
                $mensagem = "Price field must be a decimal value";
                header('Location: ./add-product.php?mensagem=' .urlencode($mensagem));
                exit();
            }else {
                $this->price = $price;
                return $this;
            }
            
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
            if($idProduct == ''){
                
                $mensagem = "idProduct field must not be empty";
                header('Locatin: ./index.php?mensagem=' .urlencode($mensagem));
                exit();
            ;
            }else if(!filter_var($idProduct, FILTER_VALIDATE_INT)){
                $mensagem = "idProduct field must be a integer value";
                header('Location: ./index.php?mensagem=' .urlencode($mensagem));
                exit();
            }else {
                $this->idProduct = $idProduct;
                return $this;
            }
        }
    }



    /**
     * Summary of ConcreteProduct
     */
    class ConcreteProduct extends Product {

        /**
         * Summary of selectAll
         * @param mixed $conexao
         * @return array<object>
         */
        public function selectAll($conexao) {
            $sql = "SELECT * FROM tblproduct ORDER BY idProduct";
            
            $result = $conexao->query($sql);

            $data = array();
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $obj = new $row["type"];
                    $obj->setInfo($row);
                    $data[] = $obj;
                }
            }

            return $data;
        }

    }



    
    /**
     * Summary of DVD
     */
    class DVD extends Product{
        /**
         * Summary of size
         * @var
         */
        private $size;

        /**
         * Summary of setInfo
         * @param mixed $info
         * @return void
         */
        public function setInfo($info){
            parent::setInfo($info);
            $this->setSize($info['size']);
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
                        name='product_id[]'
                        value='".$this->getIdProduct()."'>
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
         * @return void
         */
        public function insertInfo($conexao){

            $sku = $this->getSKU();
            $name = $this->getName();
            $price = $this->getPrice();
            $size = $this->getSize();



            $query = "INSERT INTO tblproduct (SKU, name, price, size, type) VALUES 
            (?, ?, ?, ?, 'dvd')";

            $stmt = $conexao->prepare($query);

            $stmt->bind_param('ssdd', $sku, $name, $price, $size);

            if ($stmt->execute() === TRUE) {
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
            if($size == ''){
                
                $mensagem = "Size field must not be empty";
                header('Location: ./add-product.php?mensagem=' .urlencode($mensagem));
                exit();
            ;
            }else{
                $this->size = $size;
                return $this;
            }
            
        }
        }

        /**
         * Summary of Book
         */
        class Book extends Product{
            /**
             * Summary of weight
             * @var
             */
            private $weight;

        /**
         * Summary of setInfo
         * @param mixed $info
         * @return void
         */
        public function setInfo($info){
            parent::setInfo($info);
            $this->setWeight($info['weight']);
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
                        name='product_id[]'
                        value='".$this->getIdProduct()."'>
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
        public function insertInfo($conexao){



            $sku = $this->getSKU();
            $name = $this->getName();
            $price = $this->getPrice();
            $weight = $this->getWeight();



            $query = "INSERT INTO tblproduct (SKU, name, price, weight, type) VALUES 
            (?, ?, ?, ?, 'book')";

            $stmt = $conexao->prepare($query);

            $stmt->bind_param('ssdd', $sku, $name, $price, $weight);

            if ($stmt->execute() === TRUE) {
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
            if($weight == ''){
                
                $mensagem = "weight field must not be empty";
                header('Location: ./add-product.php?mensagem=' .urlencode($mensagem));
                exit();
            ;
            }else if(!filter_var($weight, FILTER_VALIDATE_FLOAT)){
                $mensagem = "weight field must be a decimal value";
                header('Location: ./add-product.php?mensagem=' .urlencode($mensagem));
                exit();
            }else {
                $this->weight = $weight;
                return $this;
            }
            
            
            
        }
    }
    /**
     * Summary of Furniture
     */
    class Furniture extends Product{
        /**
         * Summary of height
         * @var
         */
        private $height;
        /**
         * Summary of length
         * @var
         */
        private $length;
        /**
         * Summary of width
         * @var
         */
        private $width;


        /**
         * Summary of setInfo
         * @param mixed $info
         * @return void
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
                        name='product_id[]'
                        value='".$this->getIdProduct()."'>
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

            $sku = $this->getSKU();
            $name = $this->getName();
            $price = $this->getPrice();
            $height = $this->getHeight();
            $length = $this->getLength();
            $width = $this->getWidth();



            $query = "INSERT INTO tblproduct (SKU, name, price, height, width, length, type) VALUES 
            (?, ?, ?, ?, ?, ?, 'furniture')";

            $stmt = $conexao->prepare($query);

            $stmt->bind_param('ssdddd', $sku, $name, $price, $height, $width, $length);

            if ($stmt->execute() === TRUE) {
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

            if($height == ''){
                
                $mensagem = "Height field must not be empty";
                header('Locatin: ./add-product.php?mensagem=' .urlencode($mensagem));
                exit();
            ;
            }else if(!filter_var($height, FILTER_VALIDATE_FLOAT)){
                $mensagem = "Height field must be a decimal value";
                header('Location: ./add-product.php?mensagem=' .urlencode($mensagem));
                exit();
            }else {
                $this->height = $height;
                return $this;
            }
            
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

            if($length == ''){
                
                $mensagem = "Length field must not be empty";
                header('Locatin: ./add-product.php?mensagem=' .urlencode($mensagem));
                exit();
            ;
            }else if(!filter_var($length, FILTER_VALIDATE_FLOAT)){
                $mensagem = "Length field must be a decimal value";
                header('Location: ./add-product.php?mensagem=' .urlencode($mensagem));
                exit();
            }else {
                $this->length = $length;
                return $this;
            }
            
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

            if($width == ''){
                
                $mensagem = "Width field must not be empty";
                header('Locatin: ./add-product.php?mensagem=' .urlencode($mensagem));
                exit();
            ;
            }else if(!filter_var($width, FILTER_VALIDATE_FLOAT)){
                $mensagem = "Width field must be a decimal value";
                header('Location: ./add-product.php?mensagem=' .urlencode($mensagem));
                exit();
            }else {
                $this->width = $width;
                return $this;
            }
            
        }
    }
    
    
?>


