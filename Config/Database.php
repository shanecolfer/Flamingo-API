<?php
  class Database
  {
    public $host = 'localhost';
    public $db_name = 'flamingo';
    public $username = 'root';
    public $password = '';

    //Connect
    public function connect()
    {
      $this->conn = null;

      $this->conn = new PDO('mysql:host=' . $this->host. ';dbname=' . $this->db_name,
                             $this->username, $this->password);

      return $this->conn;
    }

  }


 ?>
