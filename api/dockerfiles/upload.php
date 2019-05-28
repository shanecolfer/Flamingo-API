<?php

include_once 'C:\xampp\htdocs\flamingo\api\dockerfiles\unzip.php';
include_once 'C:\xampp\htdocs\flamingo\api\dockerfiles\createDBEntry.php';
include_once 'C:\xampp\htdocs\flamingo\config\Database.php'; //Use Database class rather than hard coding
//info here
$database = new Database(); //Create database object

//DB Define
$con = mysqli_connect($database -> host,$database -> username,$database -> password,$database -> db_name);

$response = array();

if(mysqli_connect_errno())
{
    $response["MESSAGE"] = "ERROR CONNECTING TO DATABASE";
    $response["STATUS"] = 500;
}
else
{
    if(is_uploaded_file($_FILES["file"]["tmp_name"]))
    {
        $tmp_file = $_FILES["file"]["tmp_name"];
        $file_name = $_FILES["file"]["name"];
        $file_size = $_FILES["file"]["size"];


        $destination_path = 'C:\xampp\htdocs\uploads1'.DIRECTORY_SEPARATOR;
        $target_path = $destination_path . basename( $_FILES["file"]["name"]);


        $fileExt = explode('.', $file_name); //.zip
        $fileExt = strtolower(current($fileExt)); //GoForestRun

        $download_path = 'localhost/uploads1/'.$fileExt;

        //Get Duplicate paths
        $result = mysqli_query($con,"SELECT COUNT(path) FROM dockerfiles WHERE path = '$download_path'");

        //Put result into array
        $row = mysqli_fetch_assoc($result);
        //Into keys
        $keys = array_keys($row);

        //If there is a duplicate:
        if($row[$keys[0]] > 0)
        {
            //Echo Error Response
            $response["MESSAGE"] = "UPLOAD FAILED DUPLICATE APP";
            $response["STATUS"] = 404;
            echo json_encode($response);
        }
        else
        {
            //For Unzip
            $file_name = 'C:\\xampp\\htdocs\\uploads1\\'.$file_name;
            $unzip_path = 'C:\\xampp\\htdocs\\uploads1\\'.$fileExt; //CHANGE THIS IF NEEDED this makes a folder for files to be zipped into
            //For DB update
            $unzipped_path = 'C:\\xampp\\htdocs\\uploads1\\'.$fileExt;


            if(move_uploaded_file($tmp_file, $target_path))
            {
                //mysqli_query($con,"INSERT INTO dockerfiles (name,size,download) VALUES ('$file_name','$file_size','$download_path')");

                $unzip = new Unzip($file_name, $unzip_path);
                $unzip -> unzip();

                //Create an entry
                $createDBEntry = new CreateDBEntry($file_size, $download_path, $unzipped_path);
                $createDBEntry -> createDBEntry();

            }
            else
            {
                $response["MESSAGE"] = "UPLOAD FAILED";
                $response["STATUS"] = 404;
            }



        }
    }
    else
    {
        $response["MESSAGE"] = "INVALID REQUEST";
        $response["STATUS"] = "400";
    }

}



?>
