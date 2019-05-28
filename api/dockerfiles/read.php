<?php

  // Headers
  header('Access-Control-Allow-Origin: *'); //NO titleISATION
  header('Content-Type: application/json');

  include_once 'C:\xampp\htdocs\flamingo\config\Database.php';
  include_once 'C:\xampp\htdocs\flamingo\config\models\dockerfiles.php';

  //DB
  $database = new Database(); $db = $database->connect();


  //Instansiate DockerFiles Object
  $dockerfiles = new dockerfiles($db);

  //Dockerfiles Query
  $result = $dockerfiles->read();

  //Row Count
  $num = $result->rowCount();

  if($num > 0)
  {
    //Array of Dockerfiles
    //$dockerfiles_array = array();
    $dockerfiles_array = array();
    $dockerfiles_array['data'] = array();





    while($row = $result->fetch(PDO::FETCH_ASSOC))
    {
      extract ($row);

      $dockerfiles_item = array('id' => $id,'title' => $title,'description' =>  $description,'author' => $author,'size' => $size,'path' => $path, 'rating' => $rating, 'a_rating' => $a_rating);

      //Push to data
      array_push($dockerfiles_array['data'], $dockerfiles_item);


    }

    //JSONify
    echo json_encode($dockerfiles_array);
    //Push to data
    array_push($dockerfiles_array['data'], $dockerfiles_item);

  }
  else
  {
    echo "Error No Applications";
  }





 ?>
