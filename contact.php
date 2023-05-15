<?php
$title = "Contact";
require_once 'template/header.php';
include('includes/uploader.php');
require 'classes/Service.php';

if (isset($_SESSION['contact_form'])) {
    // print_r($_SESSION['contact_form']);
}

$s = new Service;
$s->taxRate = .05;

$services = $mysqli->query('select id,name,price from services order by name')->fetch_all(MYSQLI_ASSOC);
?>

<h1>Contact us</h1>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data" method="post">
    <div class="form-group">
        <label for="name">Yor name</label>
        <input type="text" name="name" value="<?php if(isset($_SESSION['contact_form']['name'])) echo $_SESSION['contact_form']['name'] ?>" class="form-control" placeholder="Your name">
        <span class="text-danger"><?php echo $nameError ?></span>
    </div>
    <div class="form-group">
        <label for="email">Yor email</label>
        <input type="email" name="email" value="<?php if(isset($_SESSION['contact_form']['email'])) echo $_SESSION['contact_form']['email'] ?>" class="form-control" placeholder="Your email">
        <span class="text-danger"><?php echo $emailError ?></span>
    </div>
    <div class="form-group">
    <label for="document">Your document</label>
    <input type="file" name="document" class="form-control" placeholder="Your document"></input>
    <span class="text-danger"><?php echo $documentError?></span>
  </div>
    <div class="form-group">
        <label for="services">Services</label>
        <select name="service_id" id="services" class="form-control">
            <?php foreach($services as $service) { ?>
                <option value="<?php echo $service['id'] ?>">
                <?php echo $service['name'] ?>
                (<?php echo $s->price($service['price']) ?>) SAR
                </option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group">
        <label for="message">Description</label>
        <textarea name="message" class="form-control" placeholder="Your name"><?php if(isset($_SESSION['contact_form']['message'])) echo $_SESSION['contact_form']['message'] ?></textarea>
        <span class="text-danger"><?php echo $messageError ?></span>
    </div>
    <button class="btn btn-primary">send</button>
</form>

<?php require_once 'template/footer.php' ?>