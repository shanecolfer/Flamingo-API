<?php
  class Dockerfiles
  {
    private $conn;
    private $table = 'dockerfiles';

    //Dockerfiles Properties
    public $id;
    public $title;
    public $description;
    public $author;
    public $size;
    public $path;
    public $rating;
    public $a_rating;


    //Constructor with DB
    public function __construct($db)
    {
      $this->conn = $db;
    }

    //READ WHOLE DATABASE

    public function read() //Get Dockerfiles Info
    {
      $query = 'SELECT id, title, description, author, size, path, rating, a_rating FROM ' . $this->table .'';

      //Prepare Statement

      $stmt = $this->conn->prepare($query); //PDO

      //Execute

      $stmt->execute();

      return $stmt;

    }

    //READ SINGLE FROM DATABASE

    public function read_single() //Read a single dockerfile from
    {
      $query = 'SELECT id, title, description, author, size, path, rating, a_rating FROM ' . $this->table .' WHERE id = ? LIMIT 0,1';

      //Prepare Statement
      $stmt = $this->conn->prepare($query);

      //Bind ID
      $stmt->bindParam(1,$this->id);


      //Execute query
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      //Set Properties
      $this->id = $row['id'];
      $this->title = $row['title'];
      $this->description = $row['description'];
      $this->author = $row['author'];
      $this->size = $row['size'];
      $this->path = $row['path'];
      $this->rating = $row['rating'];
      $this->a_rating = $row['a_rating'];

    }

    //CREATE ENTRY IN DATABASE

    public function create()
    {
      //Query
      $query = 'INSERT INTO ' . $this->table . '
      SET
        id = :id,
        title = :title,
        description = :description,
        author = :author,
        size = :size,
        path = :path,
        rating = :rating,
        a_rating = :a_rating';

      //Statement with connect
      $stmt = $this->conn->prepare($query);

      //Clean data
      $this->id = htmlspecialchars(strip_tags($this->id));
      $this->title = htmlspecialchars(strip_tags($this->title));
      $this->description = htmlspecialchars(strip_tags($this->description));
      $this->author = htmlspecialchars(strip_tags($this->author));
      $this->size = htmlspecialchars(strip_tags($this->size));
      $this->path = htmlspecialchars(strip_tags($this->path));
      $this->rating = htmlspecialchars(strip_tags($this->rating));
      $this->a_rating = htmlspecialchars(strip_tags($this->a_rating));

      // Bind Data
      $stmt->bindParam(':id', $this->id);
      $stmt->bindParam(':title', $this->title);
      $stmt->bindParam(':description', $this->description);
      $stmt->bindParam(':author', $this->author);
      $stmt->bindParam(':size', $this->size);
      $stmt->bindParam(':path', $this->path);
      $stmt->bindParam(':rating', $this->rating);
      $stmt->bindParam(':a_rating', $this->a_rating);

      //Execute
      if($stmt->execute())
      {
        return true;
      }

      //If Error
      printf("Error: %s.\n", $stmt->error);

      return false;


    }
  }
 ?>
