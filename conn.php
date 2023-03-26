

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
            $this->setIdProduct($info['idProduct']);
            $this->setSKU($info['sku']);
            $this->setName($info['name']);
            $this->setPrice($info['price']);
        }

        /**
         * Summary of setInfoPOST
         * @param mixed $post
         * @return void
         */
        public function setInfoPOST($post){
            $this->setSKU($post['SKU']);
            $this->setName($post['name']);
            $this->setPrice($post['price']);
        }

        /**
         * Summary of validInfo
         * @param mixed $conexao
         * @return bool
         */
        public function validInfo($conexao){

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

        


        /**
         * Summary of insertInfoQuery
         * @return void
         */
        public function insertInfoQuery(){
            
        }




        /**
         * Summary of renderInfo
         * @return void
         */
        /**
         * It's a function that renders the product information in a table.
         */
        public function renderInfo(){
            echo ("
                <div class='box'>
                    <div id='chkbx'>
                        <input class='delete-checkbox' 
                        type='checkbox' 
                        name='".$this->getIdProduct()."'>
                    </div>
                    ".$this->getSKU()."<br>
                    ".$this->getName()."<br>
                    ".number_format($this->getPrice(), 2)." $<br>"
                             
            );
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
         * It takes the post data from the form and sets the size of the object
         * 
         * 
         */
        public function setInfoPOST($post){
            parent::setInfoPOST($post);
            $this->setSize($post['size']);
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
            parent::renderInfo();

            echo ("
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
        public function insertInfoQuery(){
            
            $query = "INSERT INTO tblproduct (SKU, name, price, size, type) VALUES ('".
                $this->getSKU()."', '".$this->getName()."', '"
                .$this->getPrice()."', '".$this->getSize()."', 'dvd')";
            return $query;
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
         * The function sets the weight of the object to the value of the weight key in the post array
         * 
         * 
         */
        /**
         * The function setInfoPOST() is a function that takes in a post variable and sets the
         * information of the parent class and the weight of the child class
         * 
         * 
         */
        public function setInfoPOST($post){
            parent::setInfoPOST($post);
            $this->setWeight($post['weight']);
        }

        /**
         * Summary of renderInfo
         * @return void
         */
        
        /*
        // Render information of the book 
        */
        public function renderInfo(){
            parent::renderInfo();

            echo ("
                    Weight: ".$this->getWeight()." Kg
                  
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
        public function insertInfoQuery(){
            
            $query = "INSERT INTO tblproduct (SKU, name, price, weight, type) VALUES ('"
            .$this->getSKU()."', '".$this->getName()."', '"
            .$this->getPrice()."', '".$this->getWeight()."', 'book')";
            
            
            return $query;
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
         * Summary of setInfoPOST
         * @param mixed $post
         * @return void
         */
        /**
         * The function sets the height, length, and width of the object.
         * 
         * 
         */
        public function setInfoPOST($post){
            parent::setInfoPOST($post);
            $this->setHeight($post['height']);
            $this->setLength($post['length']);
            $this->setWidth($post['width']);
        }
        
        /**
         * Summary of renderInfo
         * @return void
         */
        public function renderInfo(){
            parent::renderInfo();

            echo ("
                    Dimension: ".$this->getHeight()."x"
                    .$this->getWidth()."x"
                    .$this->getLength()."
                  
                </div>
            ");
        }

        /**
         * Summary of insertInfoQuery
         * @return string
         */
        public function insertInfoQuery(){
            
            $query = "INSERT INTO tblproduct 
            (SKU, name, price, height, width, length, type) VALUES 
            ('".$this->getSKU()."', '".$this->getName()."', '"
            .$this->getPrice()."', '".$this->getHeight()."', '"
            .$this->getWidth()."', '".$this->getLength()."', 'furniture')";

            return $query;
            
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


