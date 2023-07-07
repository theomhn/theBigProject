<?php

abstract class Model
{
    // Informations de la base de données
    private $host = CONFIG['dbHost'];
    private $db_name = CONFIG['dbName'];
    private $username = CONFIG['dbUsername'];
    private $password = CONFIG['dbPassword'];

    // Propriété qui contiendra l'instance de la connexion
    protected $_connexion;

    // Propriétés permettant de personnaliser les requêtes
    public $table;

    /**
     * Constructeur de la classe Model
     *
     * @param string $table
     */
    public function __construct($table)
    {
        $this->table = $table;
        $this->getConnection();
    }

    /**
     * Établit une connexion à la base de données
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

    /**
     * Récupère tous les enregistrements de la table
     *
     * @param array $params
     * @return array
     */
    public function getAll($params = ['*'])
    {
        if ($params === ['*']) {
            return $this->_connexion->query("SELECT * FROM $this->table;")->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $fieldList = implode(', ', $params);
            return $this->_connexion->query("SELECT $fieldList FROM $this->table;")->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    /**
     * Récupère un enregistrement par son identifiant
     *
     * @param mixed $id
     * @param array $params
     * @return array
     */
    public function get($id, $params = ['*'])
    {
        if ($params === ['*']) {
            return $this->_connexion->query("SELECT * FROM $this->table WHERE id = $id;")->fetch(PDO::FETCH_ASSOC);
        } else {
            $fieldList = implode(', ', $params);
            return $this->_connexion->query("SELECT $fieldList FROM $this->table WHERE id = $id;")->fetch(PDO::FETCH_ASSOC);
        }
    }

    /**
     * Crée un nouvel enregistrement
     *
     * @param array $params
     * @return array
     */
    public function create($params)
    {
        $fields = implode(', ', array_keys($params));
        $values = array_values($params);
        $placeholder = implode(', ', array_fill(0, count($values), '?'));

        $this->_connexion->prepare("INSERT INTO $this->table ($fields) VALUES ($placeholder);")->execute($values);

        return $this->get($this->_connexion->lastInsertId());
    }

    /**
     * Met à jour un enregistrement
     *
     * @param mixed $id
     * @param array $params
     * @return array
     */
    public function update($id, $params)
    {
        $placeholder = [];
        foreach ($params as $key => $value) {
            $placeholder[] = $key . " = ?";
        }
        $setClause = implode(', ', $placeholder);

        $values = array_values($params);

        $this->_connexion->prepare("UPDATE $this->table SET $setClause WHERE id = $id")->execute($values);
        return $this->get($this->_connexion->lastInsertId());
    }

    /**
     * Supprime un enregistrement par son identifiant
     *
     * @param mixed $id
     * @return void
     */
    public function delete($id)
    {
        $this->_connexion->query("DELETE FROM $this->table WHERE id = $id");
    }
}
