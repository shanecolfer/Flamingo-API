<?php

include_once 'C:\xampp\htdocs\flamingo\config\Database.php';
include_once 'C:\xampp\htdocs\flamingo\config\models\dockerfiles.php';

class CreateDBEntry
{
    private $fileSize;
    private $downloadPath;
    private $filePath;


    public function __construct($fileSize, $downloadPath, $filePath)
    {
        $this->fileSize = $fileSize;
        $this->downloadPath = $downloadPath;
        $this->filePath =$filePath;


    }

    public function createDBEntry()
    {
        $response = array();

        $database = new Database();
        $db = $database->connect();

        //Instansiate new Dockerfiles object
        $dockerfiles = new dockerfiles($db);


        $data = json_decode(file_get_contents( $this ->filePath."\\app.json"));

        $dockerfiles->title = $data->title;
        $dockerfiles->description = $data->description;
        $dockerfiles->author = $data->author;
        $dockerfiles->size = $this-> fileSize;
        $dockerfiles->path = $this -> downloadPath;


        if($dockerfiles->title == null || $dockerfiles->description == null || $dockerfiles->author == null)
        {
            $response["MESSAGE"] = "UPLOAD FAILED";
            $response["STATUS"] = 404;

            echo json_encode($response);

        }
        else
        {
            $dockerfiles->create();

            $response["MESSAGE"] = "UPLOAD SUCCESS";
            $response["STATUS"] = 200;

            echo json_encode($response);
        }
    }
}