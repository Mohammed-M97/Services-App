<?php 
$title = "Password reset";
require_once 'template/header.php';
require 'config/app.php';
require_once 'config/database.php';

if (isset($_SESSION['logged_in'])) {
    header('location: index.php');
}

$errors = [];
$email = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($mysqli, $_POST['email']);

    if(empty($email)){array_push($errors, "Email is required");}

    if (!count($errors)) {
        $userExists = $mysqli->query("select id, email from users where email='$email' limit 1");

        if ($userExists->num_rows) {

            $userId = $userExists->fetch_assoc()['id'];

            $tokenExists = $mysqli->query("delete from password_resets where user_id='$userId'");
            
            $token = bin2hex(random_bytes(16));
            $expires_at = date('Y-m-d H:i:s', strtotime('+1 day'));

            $mysqli->query("insert into password_resets (user_id, token, expires_at) values('$userId', '$token', '$expires_at')");

            $changePasswordUrl = $config['app_url'].'change_password.php?token='.$token;

            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=UFT-8' . "\r\n"; 

            $headers .= 'From: '.$config['admin_email']."\r\n".
                    'Reply-To: '.$email."\r\n" .
                    'X-Mailer: PHP/' . phpversion();

            $htmlMessage ='<html><body>';
            $htmlMessage .= '<p style = "#ff0000">'.$changePasswordUrl.'</p>';
            $htmlMessage .= '</body></html>';


            mail($email, 'You have new message', $htmlMessage, $headers);

        }
        $_SESSION['success_message'] = 'Please check your email for password reset link';
        header('location: password_reset.php');
    }
}   
?>

<div id="login">

    <h4>Password reset</h4>
    <h5>Please fill in your email to resret your password</h5>
    <hr>
    <?php include 'template/errors.php' ?>
    <form action="" method="post">
        <div class="form-group">
            <label for="email">Your Email:</label>
            <input type="email" name="email" class="form-control" placeholder="Your email" id="email" value="<?php echo $email ?>">
        </div>
        <div class="form-group">
            <button class="btn btn-primary">Request password reset link!</button>
        </div>
    </form>
</div>

<?php include 'template/footer.php';