<?php
$title = "Create services";
$icon = "users";
include __DIR__. '/../template/header.php';

$errors = [];
$name = '';
$description = '';
$price = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($mysqli, $_POST['name']);
    $description = mysqli_real_escape_string($mysqli, $_POST['description']);
    $price = mysqli_real_escape_string($mysqli, $_POST['price']);

    if(empty($name)){array_push($errors, "Name is required");}
    if(empty($description)){array_push($errors, "Description is required");}
    if(empty($price)){array_push($errors, "Price is required");}

    // create a new services

    if (!count($errors)) {

        $query = "insert into services (name, description, price) values ('$name', '$description', '$price')";
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
                        <label for="name">Name:</label>
                        <input type="text" name="name" class="form-control" placeholder="Your name" id="name" value="<?php echo $name ?>">
                    </div>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea name="description" id="description" cols="30" rows="10" class="form-control"><?php $description ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="price">Price:</label>
                        <input type="number" name="price" class="form-control" id="price" value="<?php echo $price ?>">
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