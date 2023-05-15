<?php 
$title = "Login";
require_once 'template/header.php';
require 'config/app.php';
require_once 'config/database.php';
// session_start();

if (isset($_SESSION['logged_in'])) {
    header('location: index.php');
}

$errors = [];
$email = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($mysqli, $_POST['email']);
    $password = mysqli_real_escape_string($mysqli, $_POST['password']);

    if(empty($email)){array_push($errors, "Email is required");}
    if(empty($password)){array_push($errors, "Password is required");}

    if (!count($errors)) {
        $userExists = $mysqli->query("select id, email, name, password, role from users where email='$email' limit 1");

        if (!$userExists->num_rows) {

            array_push($errors, "Your email, $email doesn't exists in our records!");

        } else {

            $founduser = $userExists->fetch_assoc();
            
            if (password_verify($password, $founduser['password'])) {
                
                // log in
                $_SESSION['logged_in'] = true;
                $_SESSION['user_id'] = $founduser['id'];
                $_SESSION['user_name'] = $founduser['name'];
                $_SESSION['user_role'] = $founduser['role'];

                if ($founduser['role'] == 'admin') {
                    header('location: admin');
                } else {
                    $_SESSION['success_message'] = "Welcome back, $founduser[name]";

                    header('location: index.php');
                }
                
            }else {
                array_push($errors, 'Worng credentials');
            }
        }
    }
}   
?>

<div id="login">

    <h4>Welcome back</h4>
    <h5>Please fill in the form to login</h5>
    <hr>
    <?php include 'template/errors.php' ?>
    <form action="" method="post">
        <div class="form-group">
            <label for="email">Your Email:</label>
            <input type="email" name="email" class="form-control" placeholder="Your email" id="email" value="<?php echo $email ?>">
        </div>
        <div class="form-group">
            <label for="password">Your Password:</label>
            <input type="password" name="password" class="form-control" placeholder="Your password" id="password">
        </div>
        <div class="form-group">
            <button class="btn btn-success">Login</button>
            <a href="password_reset.php">Forgot your password?</a>
        </div>
    </form>
</div>

<?php include 'template/footer.php';