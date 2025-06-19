<?php

require('etc/conf.php');

$ean='8412345678901';

$stmt = $conn->prepare('SELECT COUNT(*) FROM productos WHERE codigo_ean = :ean');
$stmt->bindParam(':ean', $ean);
$stmt->execute();

$count = $stmt->fetchColumn();

echo $count;