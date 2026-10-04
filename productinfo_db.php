<?php
require_once('database.php');

//Get all entries in the userinfo table
function get_all_products()
{
    //Query for all users
    $conn = get_db_conn();
    $query = "SELECT * FROM catalog";
    $result = mysqli_query($conn, $query);
    return $result;
}

function get_product($product_id)
{
    $conn = get_db_conn();
    $query = "SELECT * FROM catalog WHERE ProductId=$product_id";
    return mysqli_query($conn, $query);
}

?>