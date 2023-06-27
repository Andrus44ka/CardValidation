<!DOCTYPE html>
<html lang="en-EN">
<head>
    <title>Validator</title>
    <meta charset="utf-8" />
</head>
<body>
<?php
class Card_Validator
{
    function Check($card_number): string
    {
        $summ = 0;
        $issuer_visa = '/^4[0-9]\d{12,18}$|^14\d{12,18}$/';
        $issuer_mc = '/^5[1-5]\d{14}$|^62\d{14}$|^67\d{14}$/';
        if(preg_match($issuer_mc, $card_number)){
            $card_issuer = "MasterCard";
        }
        else if(preg_match($issuer_visa, $card_number)){
            $card_issuer = "VISA";
        }
        else{
            $card_issuer = "Название эмитента не определено";
        }
        $len = strlen($card_number);
        for ($i=0; $i < $len; $i++){
            $figure = $card_number % 10;
            $card_number = intdiv($card_number, 10);

            if($i%2 != 0){
                $figure *= 2;
                if($figure>9)
                    $figure = intdiv($figure, 10) + $figure % 10;
            }
            $summ += $figure;
        }
        if($summ % 10 == 0){

            return "Валидная " . $card_issuer;
        }
        else{
            return "Не валидная ";
        }
    }
}
if(isset($_POST["card_number"])) {
    $Card_Validator = new Card_Validator();
    echo $Card_Validator -> Check((int)$_POST["card_number"]);
}
?>
<form method="POST">
    <p>Enter card number: <label>
            <input type="number" name="card_number" />
        </label></p>
    <input type="submit" value="Сохранить">
</form>
</body>
</html>

