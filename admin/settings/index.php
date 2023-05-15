<?php
$title = "Settings";
$icon = "fa-light fa-cubes";
include __DIR__. '/../template/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $st = $mysqli->prepare("update settings set admin_email = ?, app_name = ? where id_settings = 1");
    $st->bind_param('ss', $dbAdminEmail, $dbAppName);
    $dbAdminEmail = $_POST['admin_email'];
    $dbAppName = $_POST['app_name'];
    $st->execute();

    echo "<script>location.href = 'index.php'</script>";
}
?>

<div class="card" style="margin: 20px;">
    <div class="content">
        <h3 style="margin-left: 10px;">Update settings</h3>
        <form action="" method="post" style="margin: 10px;">
            <div class="form-group">
                <label for="app_name">Applecation name</label>
                <input type="text" name="app_name" value="<?php echo $config['app_name'] ?>" id="app_name" class="form-control">
            </div>
            <div class="form-group">
                <label for="admin_email">Admin email</label>
                <input type="email" name="admin_email" value="<?php echo $config['admin_email'] ?>" id="admin_email" class="form-control">
            </div>
            <button class="btn btn-success" type="submit">Update settings</button>
        </form>
    </div>
</div>

<?php
include __DIR__. '/../template/footer.php';