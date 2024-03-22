<?php
    require_once 'Products_storage.php';
    require_once 'Money.php';
    require_once 'Change_calc.php';

    class MyInterface {
        
        private float $customerBalance;

        public function __construct(){
            $productsStorage = new Products_storage;
            $changeCalculator = new Change_calc ;

            $this->productsStorage = $productsStorage;
            $this->customerBalance = 0.0;
            $this->changeCalculator = $changeCalculator;
        }

        public function displayProducts(){
            $products = $this->productsStorage->getAllProducts();

            foreach ($products as $product) {
                echo $product->get_name() . ' - ' . $product->get_price() . PHP_EOL;
            }
        }

        public function selectProduct(string $productName){
            $products = $this->productsStorage->getAllProducts();

            foreach ($products as $product) {
                if ($product->get_name() === $productName) {
                    return $product;
                }
            }
            return null;
        }
        
        public function insertCoin(float $coin){
            $this->customerBalance += $coin;
        }

        public function buyProduct(Product_add $product){
            if ($this->customerBalance < $product->get_price()) {
                echo "Insufficient balance.";
                return null;
            }
    
            $change = $this->changeCalculator->calculateChange($this->customerBalance - $product->get_price());
            $this->customerBalance = 0.0;
    
            return $change;
        }

        public function addProduct(string $name, float $price){
            $new_product = new Product_add($name, $price);
            $this->productsStorage->addProduct($new_product);
        }

        public function processPurchase(){
            echo "Available products:" . PHP_EOL;
            $this->displayProducts();

            $productName = readline("Enter the name of the product you want to buy: ");
            $product = $this->selectProduct($productName);

            if ($product) {
                $requiredAmount = $product->get_price();
                $customerBalance = 0.0;

                while ($customerBalance < $requiredAmount) {
                    $coin = (float)readline("Insert coin (0.01, 0.05, 0.10, 0.25, 0.50, 1.00): ");
                    $this->insertCoin($coin);
                    $customerBalance += $coin;
                }

                $change = $this->buyProduct($product);
                echo "Purchased " . $productName . PHP_EOL;
                if ($change !== null) {
                    echo "Change: " . PHP_EOL;
                    foreach ($change as $coin => $count) {
                        if ($count > 0) {
                            echo "$coin - $count" . PHP_EOL;
                        }
                    }
                } 
                self::return();
            } else {
                echo "Product not found." . PHP_EOL;
            }
        }

        public function processAdd(){
            $name = readline("Enter the name of the new product: ");
            $price = (float)readline("Enter the price of the new product(e.g:'1.2'): ");
            self::addProduct($name, $price);
            self::return();
        }

        public function return(){
            $return = readline("type 'return' to go to main menu:");
            if ($return == 'return'){self::processStart();}
        }

        public function processStart(){
            $action = readline("Enter action (buy/add): ");
            if ($action === 'buy'){
                self::processPurchase();
            }
            elseif ($action === 'add'){
                self::processAdd();
            }
        }
    }
?>