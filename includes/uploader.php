<?php 
require_once __DIR__."/../config/database.php";

$uploadDir = 'uploads';


function filterString($field) {

    $field = htmlspecialchars($field, ENT_QUOTES);

    if (empty($field)) {
        return false;
    } else {
        return $field;
    }
};

function filterEmail($field) {
    
    $field = filter_var(trim($field), FILTER_SANITIZE_EMAIL);

    if (filter_var($field, FILTER_VALIDATE_EMAIL)) {
        return $field;
    }else {
        return false;
    }

}

function canUpload($file) {
    // allowed file types
    $allowed = [

        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif'

    ];

    $maxFileSize = 10 * 1024 * 1024;

    $fileMineType = mime_content_type($file['tmp_name']);
    $fileSize = $file['size'];

    if (!in_array($fileMineType, $allowed)) {
        return "File type not allowed";
    };

    if ($fileSize > $maxFileSize) {
        return "File size not allowed";
    }

    return true;
}

$nameError = $emailError = $documentError = $messageError = '';
$name = $email = $message = '';

$fileName = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = filterString($_POST['name']);
    if (!$name) {
        $_SESSION['contact_form']['name'] = '';
        $nameError = 'Your name is required';
    } else {
        $_SESSION['contact_form']['name'] = $name;
    }

    $email = filterEmail($_POST['email']);
    if (!$email) {
        $_SESSION['contact_form']['email'] = '';
        $emailError = 'Your email is invalid';
    } else {
        $_SESSION['contact_form']['email'] = $email;
    }

    $message = filterString($_POST['message']);
    if (!$message) {
        $_SESSION['contact_form']['message'] = '';
        $messageError = 'You must enter a message';
    } else {
        $_SESSION['contact_form']['message'] = $message;
    }

    if (isset($_FILES['document']) && $_FILES['document']['error'] == 0) {
        
        $canUpload = canUpload($_FILES['document']);

        if ($canUpload === true) {
            
            $uploadDir = 'uploads';
            if (!is_dir($uploadDir)) {
                // umask(0);
                // mkdir($uploadDir ,0775);
                mkdir($uploadDir);
            }
            
            $fileName = time().$_FILES['document']['name'];

            if (file_exists($uploadDir.'/'.$fileName)){
                $documentError = 'File already exists';
            }else{

                move_uploaded_file($_FILES['document']['tmp_name'], $uploadDir .'/'.$fileName);

            }
        } else {
            $documentError = $canUpload;
        }

    }

    

    if (!$emailError && !$nameError && !$messageError && !$documentError) {


        $fileName ? $filePath = $uploadDir.'/'.$fileName : $filePath = '';
        
        $statement = $mysqli->prepare("insert into messages
        (contact_name, email, document, message, service_id)
        values (?, ?, ?, ?, ?)");

        $statement->bind_param('ssssi', $dbcontact_name, $dbemail, $dbdocument, $dbmessage, $dbservice_id);
        // $insertMessage = 
        //     "insert into messages (contact_name, email, document, message, service_id)".
        //     "values ('$name', '$email', '$fileName', '$message', ".$_POST['service_id'].")";

        // $mysqli->query($insertMessage);    

        $dbcontact_name = $name;
        $dbemail = $email;
        $dbdocument = $fileName;
        $dbmessage = $message;
        $dbservice_id = $_POST['service_id'];

        $statement->execute();

        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=UFT-8' . "\r\n"; 

        $headers .= 'From: '.$email."\r\n". 'Reply-To: '.$email."\r\n" . 'X-Mailer: PHP/' . phpversion();

        $htmlMessage ='<html><body>';
        $htmlMessage .= '<p style = "#ff0000">'.$message.'</p>';
        $htmlMessage .= '</body></html>';


        if (mail($config['admin_email'], 'You have new message', $htmlMessage, $headers)) {
            header('Location: contact.php');
            die();
        } else {
            echo "Error sending your email";
        }
        
    }
}