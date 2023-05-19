<?php

abstract class Model
{
  // Informations de la base de données
  private $host = "localhost";
  private $db_name = "TheBigProject";
  private $username = "TBP-admin";
  private $password = "(@_NUCJyJyuG/T!R";

  // Propriété qui contiendra l'instance de la connexion
  protected $_connexion;

  // Propriétés permettant de personnaliser les requêtes
  public $table;

  public function __construct($table)
  {
    $this->table = $table;
    $this->getConnection();
  }

  /**
   * Fonction d'initialisation de la base de données
   *
   * @return void
   */
  public function getConnection()
  {
    // On supprime la connexion précédente
    $this->_connexion = null;

    // On essaie de se connecter à la base
    try {
      $this->_connexion = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
      $this->_connexion->exec("set names utf8");
    } catch (PDOException $exception) {
      echo "Erreur de connexion : " . $exception->getMessage();
    }
  }


  public function getAll($params = ['*'])
  {
    if ($params === ['*']) {
      // Récupérer tous les champs
      return $this->_connexion->query("SELECT * FROM $this->table;")->fetchAll(PDO::FETCH_ASSOC);
    } else {
      // Récupérer certains champs spécifiés
      $fieldList = implode(', ', $params);
      return $this->_connexion->query("SELECT $fieldList FROM $this->table;")->fetchAll(PDO::FETCH_ASSOC);
    }
  }

  public function get($id, $params = ['*'])
  {
    if ($params === ['*']) {
      // Récupérer tous les champs
      return $this->_connexion->query("SELECT * FROM $this->table WHERE id = $id;")->fetch(PDO::FETCH_ASSOC);
    } else {
      // Récupérer certains champs spécifiés
      $fieldList = implode(', ', $params);
      return $this->_connexion->query("SELECT $fieldList FROM $this->table WHERE id = $id;")->fetch(PDO::FETCH_ASSOC);
    }
  }
  public function create($obj)
  {
    // @TODO
  }

  public function update($obj)
  {
    // @TODO
  }

  public function remove($id)
  {
    // @TODO
  }
}
