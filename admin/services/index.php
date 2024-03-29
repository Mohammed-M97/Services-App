<?php
$title = "Services";
$icon = "fa-light fa-cubes";
include __DIR__. '/../template/header.php';
$services = $mysqli->query('select * from services order by id')->fetch_all(MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $st = $mysqli->prepare('delete from services where id = ?');
    $st->bind_param('i', $servicesId);
    $servicesId = $_POST['service_id'];
    $st->execute();
    echo "<script>location.href = 'services/index.php'</script>";
}
?>

<div class="card" style="margin: 20px;">
    <div class="card-body">
        <div class="content">
            <a href="create.php" class="btn btn-success">Create a new services</a>
            <p style="margin-top: 10px;" class="header">Services: <?php echo count($services) ?></p>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th width="0">#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th width="250">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($services as $service): ?>
                        <tr>
                            <td><?php echo $service['id'] ?></td>
                            <td><?php echo $service['name'] ?></td>
                            <td><?php echo $service['description'] ?></td>
                            <td><?php echo $service['price'] ?></td>
                            <td>
                                <a style="margin-right: 10px;" href="edit.php?id=<?php echo $service['id'] ?>" class="btn btn-warning">Edit</a>
                                <form action="" style="display: inline;" method="post">
                                    <input type="hidden" value="<?php echo $service['id'] ?>" name="service_id">
                                    <button onclick="return confirm('Are you sure?')" class="btn btn-danger" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>    
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
include __DIR__. '/../template/footer.php';