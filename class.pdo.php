<?php
/**
 *
 */
class PdoHappiness
{

  private static $hote = 'mysql:host=localhost';
  private static $basededonnes = 'dbname=img-hd';
  private static $utilisateur = 'root';
  private static $motDePasse = 'root';
  private static $monPdo;
  private static $monPdoHappiness = null;

  private function __construct() {
    try {
      self::$monPdo = new PDO(self::$hote.';'.self::$basededonnes, self::$utilisateur, self::$motDePasse);
      self::$monPdo->query("SET CHARACTER SET utf8");

    } catch (Exception $e) {
      echo "Echec de la connexion";
      die;
    }
  }

  public function _destruct() {
    self::$monPdo = null;
  }

  static public function getPdoHappiness() {
    if(self::$monPdoHappiness == null) {
      self::$monPdoHappiness = new PdoHappiness();
    }
    return self::$monPdoHappiness;
  }

  static public function query($query) {
    $req = self::$monPdo->prepare($query);
    $req->execute();
    $req = $req->fetchAll();
    if($req == NULL)
      return NULL;
    else
      return $req;
  }
}
