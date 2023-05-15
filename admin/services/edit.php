<?php
$title = "Edit services";
$icon = "services";
include __DIR__. '/../template/header.php';

if (!isset($_GET['id']) || !$_GET['id']) {
    die('Missing id parameters');
}

$st = $mysqli->prepare('select * from services where id = ? limit 1');
$st->bind_param('i', $serviceId);
$serviceId = $_GET['id'];
$st->execute();

$service = $st->get_result()->fetch_assoc();

$errors = [];
$name = $service['name'];
$description = $service['description'];
$price = $service['price'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if(empty($_POST['name'])){array_push($errors, "Name is required");}
    if(empty($_POST['description'])){array_push($errors, "Description is required");}
    if(empty($_POST['price'])){array_push($errors, "Price is required");}

    if (!count($errors)) {
        $st = $mysqli->prepare('update services set name = ?, description = ?, price = ? where id = ?');
        $st->bind_param('ssdi', $dbName, $dbDescription, $dbPrice, $dbId);
        $dbName = $_POST['name'];
        $dbDescription = $_POST['description'];
        $dbPrice = $_POST['price'];
        $dbId = $_GET['id'];

        $st->execute();

        if ($st->error) {
            array_push($errors, $st->error);
        } else {
            echo "<script>location.href = 'index.php'</script>";
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
                        <textarea name="description" id="description" cols="30" rows="10" class="form-control"><?php echo $description ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="price">Price:</label>
                        <input type="number" name="price" class="form-control" id="price" value="<?php echo $price ?>">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php
include __DIR__. '/../template/footer.php';