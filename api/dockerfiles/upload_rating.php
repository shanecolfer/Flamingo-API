<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');

include_once 'C:\xampp\htdocs\flamingo\config\Database.php';

//Instansiate DB
$database = new Database();

//Define Sql Connection
$conn = new mysqli($database -> host,$database -> username,$database -> password,$database -> db_name);

//Response Array
$response = array();

//Take in php input
$id = isset($_GET['id']) ? $_GET['id'] : die();
$rating = isset($_GET['rating']) ? $_GET['rating'] : die();


if($rating<=5 && $rating>=0)
{
    $this_hit = 1;

    //DB Define
    $database = new Database(); //Create database object


    $result = mysqli_query($conn,"SELECT rating,a_rating,hits FROM dockerfiles WHERE id = '$id'");

    if (!$result) {
        echo 'Could not run query: ' . mysqli_error();
        exit;
    }

    $row = mysqli_fetch_row($result);

    $new_rating = $row[0] + $rating;
    $new_hits = $row[2] + $this_hit;

    mysqli_query($conn,"UPDATE dockerfiles SET rating = '$new_rating', hits = '$new_hits' WHERE id = '$id'");

    if (mysqli_connect_errno())
    {
        $response["MESSAGE"] = "UPDATE FAILED";
        $response["STATUS"] = 404;

        echo json_encode($response);
    }

    if($new_rating == 0)
    {
        $response["MESSAGE"] = "UPDATE SUCCESS";
        $response["STATUS"] = 200;

        echo json_encode($response);
    }
    else
    {
        $new_average = $new_rating / $new_hits;
        mysqli_query($conn,"UPDATE dockerfiles SET a_rating = '$new_average' WHERE id = '$id'");
        $response["MESSAGE"] = "UPDATE SUCCESS";
        $response["STATUS"] = 200;

        echo json_encode($response);
    }

}
else
{
    $response["MESSAGE"] = "UPDATE FAILED RATING OUT OF BOUND";
    $response["STATUS"] = 404;
    echo json_encode($response);
}


?>
