<?php

  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,
          Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once 'C:\xampp\htdocs\flamingo\config\Database.php';
  include_once 'C:\xampp\htdocs\flamingo\config\models\dockerfiles.php';

  //Instansiate DB
  $database = new Database();
  $db = $database->connect();

  //Instansiate new Dockerfiles object
  $dockerfiles = new dockerfiles($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  $dockerfiles->id = $data->id;
  $dockerfiles->title = $data->title;
  $dockerfiles->description = $data->description;
  $dockerfiles->author = $data->author;
  $dockerfiles->size = $data->size;
  $dockerfiles->path = $data->path;

  //Create dockerfile
  if($dockerfiles->create())
  {
    echo json_encode(array('Message' => 'Entry Created'));
  }
  else
  {
    echo json_encode(array('Message' => 'Error'));
  }

?>
