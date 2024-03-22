<?php
    require_once 'Product_add.php';

    class Products_storage {
        private array $products = [];
    
        public function addProduct(Product_add $product) {
            $this->products[] = $product;
        }
    
        public function getAllProducts(){
            self::launch();
            return $this->products;
        }

        public function launch(){
            $this->addProduct(new Product_add('Coca-cola', 1.50));
            $this->addProduct(new Product_add('Snickers', 1.20));
            $this->addProduct(new Product_add('Lay\'s', 2.00));
        }
    }
    
    
?>