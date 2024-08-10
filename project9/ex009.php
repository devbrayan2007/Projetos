<?php

$value = $_POST['value'];

$product_discount = $value * 0.07;

echo "Original value: US$ $value";
echo "<hr>";
echo "Discount value: 7%";
echo "<hr>";
echo "Discounted price: US$ $product_discount";