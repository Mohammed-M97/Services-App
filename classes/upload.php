<?php
class Upload {
    protected $uploadDir;
    protected $defaultUploadDir = 'uploads';
    public $file;
    public $fileName;
    public $filePath;
    protected $rootDir;
    protected $errors = [];

    public function __construct($uploadDir, $rootDir = false)
    {
        if ($rootDir) {
            $this->rootDir = $rootDir;
        }else {
            // الطريقة القديمة هذه ما تشتغل!
            // $this->rootDir = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'http://localhost:3000';

            // الطريقة هذه تشتغل
            $this->rootDir = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR ;
        }

        $this->filePath = $uploadDir;
        $this->uploadDir = $this->rootDir.'/'. $uploadDir;
    }

    protected function validate(){

        if (!$this->isSizeAllowed()) {
            array_push($this->errors, 'File size not allowed!');
        }elseif (!$this->isMimeAllowed()) {
            array_push($this->errors, 'File type not allowed!');
        }

        return $this->errors;
    }

    protected function createUploadDir(){

        if (!is_dir($this->uploadDir)) {
            umask(0);

            if (!mkdir($this->uploadDir, 0775)) {
                print_r($this->rootDir);
                array_push($this->errors, 'Could not create upload dir!');
                return false;
                print_r($this->rootDir);
            }
        }

        return true;
    }

    public function upload(){

        $this->fileName = time().$this->file['name'];
        $this->filePath .= '/' .$this->fileName;
    
        if($this->validate()){
            return $this->errors;
        }elseif(!$this->createUploadDir()){
            return $this->errors;
        }elseif(!move_uploaded_file($this->file['tmp_name'], $this->uploadDir.'/'.$this->fileName)){
            array_push($this->errors, 'Error uploading your file!');
        }

        return $this->errors;
    }

    protected function isMimeAllowed(){

        $allowed = [

            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'jpg' => 'image/jpg'
    
        ];

        $fileMineType = mime_content_type($this->file['tmp_name']);

        if (!in_array($fileMineType, $allowed)) {
            return false;
        }
            return true;
    }

    protected function isSizeAllowed(){

        $maxFileSize = 10 * 1024 * 1024;

        $fileSize = $this->file['size'];

        if ($fileSize > $maxFileSize) {
            return false;
        }

        return true;
    }
}
