<?php
    class Money{
        private float $value;
        private static array $acceptedValues = [1.00, 0.50, 0.25, 0.10, 0.05, 0.01];

        public function __construct(float $value){
            $this->value = $value;
        }

        public function getValue(){
            return $this->value;
        }

        public function isAccepted(){
            return in_array($this->value, self::acceptedValues);
        }

        public static function getAvailableCoins(){
            return self::$acceptedValues;
        }
    }
?>