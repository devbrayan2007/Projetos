<?php


$num1 = $_POST['num1'];
$num2 = $_POST['num2'];

$square_number1 = $num1 * $num1;
$square_number2 = $num2 * $num2;

$square_sum = $square_number1 + $square_number2;

echo "The square of $num1 is equal to: $square_number1";
echo "<hr>";
echo "The square of $num2 is equal to: $square_number2";
echo "<hr>";
echo "The sum of the squares is equal to: $square_sum";

