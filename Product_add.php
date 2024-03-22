<?php
    class Product_add
    {
        private string $name;
        private float $price;

        public function __construct(string $name, float $price){
            $this->name = $name;
            $this->price = $price;
        }

        public function get_name(){
            return $this->name;
        }
        public function get_price(){
            return $this->price;
        }
    }
?>