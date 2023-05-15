<?php 
$title = "Home Page";
require_once 'template/header.php';
require 'classes/Service.php';
require 'classes/Product.php';
require 'config/app.php';
require_once 'config/database.php';

$Service = new Service;

?>
<?php if ($Service->available) {
    ?>
    <h1>Welcome to our Website.</h1>

    <?php $products = $mysqli->query("select * from products order by name")->fetch_all(MYSQLI_ASSOC) ?>
    <div class="row mb-4" style="height: 70px;">

    <?php foreach ($products as $product) { ?>
        <div class="card mb-4" style="height: 250px; width: 250px; margin:10px;">
            <div class="card mb-4 shadow">
                <div class="custom-card-image" style="background-image: url('<?php echo $config['app_url'].$product['image'] ?>');">
                </div>
                <div class="card-body">
                    <div class="card-title"><?php echo $product['name'] ?></div>
                    <div><?php echo $product['description'] ?></div>
                    <div class="text-success"><?php echo $product['price'] ?> SAR</div>
                </div>
            </div>    
        </div>
    <?php } ?>
    </div>

    <?php

}

require_once 'template/footer.php' ?>