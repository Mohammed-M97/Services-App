<?php 
include_once  "database.php";

$setting = $mysqli->query("select * from settings where id_settings = 1")->fetch_assoc();

if (count($setting)) {
    $app_name = $setting['app_name'];
    $admin_email = $setting['admin_email'];
} else {
    $app_name = 'Service app';
    $admin_email = 'mohammed@admin';
}

$config = [
    'app_name' => $app_name,
    'app_url' => 'http://localhost:3000/',
    'admin_email' => $admin_email,
    'lang' => 'en',
    'dir' => 'ltr',
    'upload_dir' => 'uploads/',
    'admin_assets' => 'http://localhost:3000/admin/template/assets/'
];