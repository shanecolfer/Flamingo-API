<?php

include_once 'C:\xampp\htdocs\flamingo\config\Database.php';
include_once 'C:\xampp\htdocs\flamingo\config\models\dockerfiles.php';

//Create response array
$response = array();

//Instansiate DB
$database = new Database();
$db = $database->connect();

//Define SQL Conn
$conn = new mysqli($database -> host,$database -> username,$database -> password,$database -> db_name);

//Instansiate new Dockerfiles object
$dockerfiles = new dockerfiles($db);

//Get ID
$dockerfiles -> id = isset($_GET['id']) ? $_GET['id'] : die();

//Get ID Count
$id_result = mysqli_query($conn,"SELECT COUNT(id) FROM dockerfiles WHERE id = '$dockerfiles->id'");

//Fetch array
$row = mysqli_fetch_assoc($id_result);

//Put into keys
$keys = array_keys($row);

//If ID does not exist
if($row[$keys[0]] == 0)
{
    //Echo Error Response
    $response["MESSAGE"] = "DOWNLOAD FAILED ID INVALID";
    $response["STATUS"] = 404;
    echo json_encode($response);
}
else
{
    //Get Path
    $result = mysqli_query($conn,"SELECT path FROM dockerfiles WHERE id = '$dockerfiles->id'");
    //Put result into array
    $row = mysqli_fetch_assoc($result);
    //Into keys
    $keys = array_keys($row);
    //Path = returned path
    $path = $row[$keys[0]];

    //Add Zip to path
    $path = $path.'.zip';

    //Add full directory to path
    $path = str_replace('localhost','C:/xampp/htdocs',$path);

    $file_name = basename($path);

    header("Content-Type: application/zip");
    header("Content-Disposition: attachment; filename=$file_name");
    header("Content-Length: " . filesize($path));

    if(readfile($path))
    {
        $response["MESSAGE"] = "DOWNLOAD SUCCESS";
        $response["STATUS"] = 200;

        echo json_encode($response);
    }
    else
    {
        $response["MESSAGE"] = "DOWNLOAD FAILED";
        $response["STATUS"] = 404;

        echo json_encode($response);
    }

    exit;
}




