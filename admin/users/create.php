<?php
$title = "Create users";
$icon = "users";
include __DIR__. '/../template/header.php';

$errors = [];
$name = '';
$email = '';
$role = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($mysqli, $_POST['name']);
    $email = mysqli_real_escape_string($mysqli, $_POST['email']);
    $password = mysqli_real_escape_string($mysqli, $_POST['password']);
    $role = mysqli_real_escape_string($mysqli, $_POST['role']);

    if(empty($name)){array_push($errors, "Name is required");}
    if(empty($email)){array_push($errors, "Email is required");}
    if(empty($password)){array_push($errors, "Password is required");}
    if(empty($role)){array_push($errors, "Role is required");}

    if (!count($errors)) {
        $userExists = $mysqli->query("select id, email from users where email='$email' limit 1");

        if ($userExists->num_rows) {
            array_push($errors, "Email is aready registered!");
        }
    }

    // create a new user

    if (!count($errors)) {
        $password = password_hash($password, PASSWORD_DEFAULT);

        $query = "insert into users (name, email, password, role) values ('$name', '$email', '$password', '$role')";

        try {
            // هنا راح يتنفذ الاستعلام لو سليم بيشتغل تمام ولو فيه مشكلة راح يشتغل الكود التالي في catch
            $mysqli->query($query);
        }catch(Exception $e){
                // في حال حدوث خطا تقدر تلتقط الخطا هذا من المتغير $e
                array_push($errors, $e->getMessage());
        }

    }
}   
?>
    <div class="card" style="margin: 20px;">
        <div class="card-body">
            <div class="content">
                <?php include __DIR__. '/../template/errors.php' ?>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="name">Your Name:</label>
                        <input type="text" name="name" class="form-control" placeholder="Your name" id="name" value="<?php echo $name ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Your Email:</label>
                        <input type="email" name="email" class="form-control" placeholder="Your email" id="email" value="<?php echo $email ?>">
                    </div>
                    <div class="form-group">
                        <label for="password">Your Password:</label>
                        <input type="password" name="password" class="form-control" placeholder="Your password" id="password">
                    </div>
                    <div class="form-group">
                        <label for="role">Role:</label>
                        <select name="role" id="role" class="form-control">
                            <option value="user"
                            <?php if($role == 'user') echo 'selected' ?>
                            >User</option>
                            <option value="admin"
                            <?php if($role == 'admin') echo 'selected' ?>
                            >Admin</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php
include __DIR__. '/../template/footer.php';