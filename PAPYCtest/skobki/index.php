<?php

// $str = "(()()5 * (4 - 2))";
$str = "5 * (4 - 2)";
// $str = "5 * (4 - 2(";

$openSum = preg_match_all("/\(/", $str);
$closeSum = preg_match_all("/\)/", $str);
$pos1 = strpos($str, '(');
$pos2 = strpos($str, ')');

//если закрывающая скобка впереди или кол-во скобок не совпадает
if ($pos2 < $pos1 || $openSum != $closeSum)
    echo "Ошибка";
else
    echo "Все ок";
