<?php
$title = "Edit products";
$icon = "products";
include __DIR__. '/../template/header.php';
require_once __DIR__. '/../../classes/upload.php';
// include __DIR__.'/../../config/app.php';


if (!isset($_GET['id']) || !$_GET['id']) {
    die('Missing id parameters');
}

$st = $mysqli->prepare('select * from products where id = ? limit 1');
$st->bind_param('i', $productId);
$productId = $_GET['id'];
$st->execute();

$product = $st->get_result()->fetch_assoc();

$errors = [];
$name = $product['name'];
$description = $product['description'];
$price = $product['price'];
$image = $product['image'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if(empty($_POST['name'])){array_push($errors, "Name is required");}
    if(empty($_POST['description'])){array_push($errors, "Description is required");}
    if(empty($_POST['price'])){array_push($errors, "Price is required");}

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        
        $date = date('Ym');
        $upload = new Upload('uploads/products/'.$date);
        $upload->file = $_FILES['image'];
        $errors = $upload->upload();

        if (!count($errors)) {

            unlink($_SERVER['DOCUMENT_ROOT']. DIRECTORY_SEPARATOR. $image);

            $image = $upload->filePath;
        }
    }

    if (!count($errors)) {
        $st = $mysqli->prepare('update products set name = ?, description = ?, price = ?, image = ? where id = ?');
        $st->bind_param('ssdsi', $dbName, $dbDescription, $dbPrice, $dbImage, $dbId);
        $dbName = $_POST['name'];
        $dbDescription = $_POST['description'];
        $dbPrice = $_POST['price'];
        $dbImage = $image;
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
                <form action="" method="post" enctype="multipart/form-data">
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
                        <img src="<?php echo $config['app_url'].'/'.$image ?>" width="150" alt="">
                        <label for="image">Image:</label>
                        <input type="file" name="image">
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