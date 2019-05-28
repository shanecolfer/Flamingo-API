<?php

  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: GET');

  include_once 'C:\xampp\htdocs\flamingo\config\Database.php';
  include_once 'C:\xampp\htdocs\flamingo\config\models\dockerfiles.php';

  //Instansiate DB
  $database = new Database();
  $db = $database->connect();

  //Instansiate new Dockerfiles object
  $dockerfiles = new dockerfiles($db);


  //Get ID
  $dockerfiles -> id = isset($_GET['id']) ? $_GET['id'] : die();

  //Get Dockerfiles
  $dockerfiles->read_single();

  //Create Array
  $dockerfiles_array = array
  (
      'a_rating' => $dockerfiles -> a_rating
  );

  print_r(json_encode($dockerfiles_array));

 ?>