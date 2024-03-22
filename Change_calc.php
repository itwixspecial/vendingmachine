<?php
    require_once 'Money.php';

    class Change_calc{
        public function calculateChange(float $amount){
            
            $availableCoins = Money::getAvailableCoins();
            $change = array_fill_keys($availableCoins, 0);

            foreach ($availableCoins as $coin){   
                while ($amount >= $coin){
                    $change[(string)$coin]++;
                    $amount -= $coin;
                    $amount = round($amount, 2);

                    if ($change[(string)$coin] < 1){
                        unset($change[(string)$coin]);
                    }
                }
                
            }

            return $change;
        }
        
    }
?>