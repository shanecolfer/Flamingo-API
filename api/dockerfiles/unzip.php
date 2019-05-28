<?php
    class  Unzip
    {
        private $fileName;
        private $filePath;

        public function __construct($fileName,$filePath)
        {
            $this->fileName = $fileName;
            $this->filePath = $filePath;
        }

        public function unzip()
        {


            $zip = new ZipArchive;
            $res = $zip->open($this -> fileName); //CHANGE THIS TO VARIABLE INPUT FROM OBJECT
            if ($res === TRUE)
            {
                $zip -> extractTo($this -> filePath); //CHANGE THIS TO VARIABLE INPUT FROM OBJECT
                $zip -> close();
            }
            else
            {
                echo "Error Unzipping File";
            }
    }
}