<?php

$note1 = $_POST['note1'];
$note2 = $_POST['note2'];
$note3 = $_POST['note3'];

$medium = ($note1 + $note2 + $note3) / 3;
echo "Average obtained: " . round($medium);
