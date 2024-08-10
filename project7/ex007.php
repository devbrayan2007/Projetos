<?php

$height = $_POST['height'];
$weight = $_POST['weight'];

$bmi = $weight / ($height * $height);

echo "Your BMI is equal to " . round($bmi);

