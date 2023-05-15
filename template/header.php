<?php 
session_start();
require_once __DIR__.'/../config/app.php';
?>
<!DOCTYPE html>
<html dir="<?php echo $config['dir'] ?>" lang="<?php echo $config['lang'] ?>">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $config['app_name'] . " | " . $title ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="main-navbar">
        <nav class="navbar navbar-expand-lg navbar-dark bg-secondary shadow">
            <div class="container-fluid">
                <a class="navbar-brand" href="<?php echo $config['app_url'] ?>"><?php echo $config['app_name'] ?></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?php echo $config['app_url'] ?>">Home</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="<?php echo $config['app_url'] ?>contact.php">Contact</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <?php if(!isset($_SESSION['logged_in'])): ?>
                    <li class="nav-item">
                    <a class="nav-link" href="<?php echo $config['app_url'] ?>login.php">Login</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="<?php echo $config['app_url'] ?>register.php">Register</a>
                    </li>
                    <?php else: ?>
                    <li class="nav-item">
                    <a class="nav-link" href="#"><?php echo $_SESSION['user_name'] ?></a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="<?php echo $config['app_url'] ?>logout.php">Logout</a>
                    </li>
                    <?php endif ?>    
                </ul>
                </div>
            </div>
        </nav>
    </div>

    <div class="container pt-5">

<?php include 'message.php' ?>