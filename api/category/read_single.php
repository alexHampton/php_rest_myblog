<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

// Instantiate DB Object and connect
$database = new Database();
$db = $database->connect();

// Instantiate blog post object
$cat = new Category($db);

// Get ID
$cat->id = isset($_GET['id']) ? $_GET['id'] : die();

// Get category
$cat->read_single();

// Create array
$cat_arr = array(
    'id' => $cat->id,
    'name' => $cat->name,
    'created_at' => $cat->created_at
);

// Make JSON
print_r(json_encode($cat_arr));
