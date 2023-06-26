<?php
class Validator
{
    function validate($card_number): string
    {
        $summa = 0;
        $len = strlen($card_number);
        $issuer = $this -> issuer($card_number);
        for ($i=0; $i < $len; $i++){
            $digit = $card_number % 10;
            $card_number = intdiv($card_number, 10);

            if($i%2 != 0){
                $digit *= 2;

                if($digit>9)
                    $digit -= 9;
            }
            $summa += $digit;
        }
        if($summa % 10 == 0){
            return "Valid " . $issuer;
        }
        else{
            return "Invalid ";
        }
    }
    function issuer($card_number): string
    {
        $r_visa = '/^(4[0-9]|14)+[0-9]{11,17}$/';
        $r_mc = '/^(5[1-5]|62|67)+[0-9]{11,17}$/';
        if(preg_match($r_mc, $card_number)){
            return "MasterCard";
        }
        else if(preg_match($r_visa, $card_number)){
            return "Visa";
        }
        else{
            return "Not defined issuer";
        }
    }
}

if(isset($_POST['card_number'])){
    $validator = new Validator();
    $card_number = (int) $_POST['card_number'];
    echo $validator -> validate($card_number);
}