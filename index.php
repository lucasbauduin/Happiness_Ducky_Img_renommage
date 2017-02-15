<?php
require_once 'class.pdo.php';
require_once 'class.image.php';
PdoHappiness::getPdoHappiness();
$pdo = PdoHappiness::getMonPdo();

$imagesData = PdoHappiness::query("SELECT * FROM realisations ORDER BY id");
foreach ($imagesData as $imageData) {
  $uneImage = new Image($imageData);
}

$lesImages = Image::getLaListe();

foreach ($lesImages as $uneImage) {
  $uneImage->imageUpdate();
}

print_r(Image::getAvertissements());
