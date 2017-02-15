<?php
class Image {
  private $apercu, $image;
  private static $cmpt = 1;
  private static $repositoryPath = "images/";
  private static $listeRealisations = array();
  private static $listeErreurs = array();

  public function __construct($imageData) {
    $this->apercu = $imageData["apercu"];
    $this->image = $imageData["image"];
    self::$listeRealisations[] = $this;
  }

  static function getLaListe() {
    return self::$listeRealisations;
  }

  public function imageUpdate() {
    if($pbApercu = file_exists(self::$repositoryPath.$this->apercu) == TRUE) {

    } else { self::$listeErreurs[] = $this->apercu." n'existe pas"; }
    if($pbImage = file_exists(self::$repositoryPath.$this->image) == TRUE) {

    } else { self::$listeErreurs[] = $this->image." n'existe pas"; }

    if($pbApercu && $pbImage) {
      $extensionApercu = strtolower(strrchr(basename($this->apercu), '.'));
      $extensionImage = strtolower(strrchr(basename($this->image), '.'));
      $nomFichierApercu = str_replace($extensionApercu, "", $this->apercu);
      $nomFichierImage = str_replace($extensionImage, "", $this->image);
      $nouveauNomApercu = "thumb_".time()."_".self::$cmpt.$extensionImage;
      $nouveauNomImage = time()."_".self::$cmpt.$extensionImage;
      self::$cmpt ++;
      echo $nomFichierApercu.$extensionApercu." -> ".$nouveauNomApercu."<br />";
      echo $nomFichierImage.$extensionImage." -> ".$nouveauNomImage."<br />";
      $this->enregistreImage($nouveauNomApercu, $nouveauNomImage);
    }
  }

  public function enregistreImage($nouveauNomApercu, $nouveauNomImage) {
    rename(self::$repositoryPath.$this->apercu, self::$repositoryPath.$nouveauNomApercu);
    rename(self::$repositoryPath.$this->image, self::$repositoryPath.$nouveauNomImage);
    PdoHappiness::query("UPDATE realisations SET apercu = ".$this->apercu.", image = ".$this->image.", new_apercu = ".$nouveauNomApercu.", new_image = ".$nouveauNomImage." WHERE apercu = ".$this->apercu);
  }

  static function getAvertissements() {
    return self::$listeErreurs;
  }
}
