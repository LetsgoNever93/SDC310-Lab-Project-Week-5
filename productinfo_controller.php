<?php
require_once('../model/productinfo_db.php');

function get_products()
{
    $product_rows = get_all_products();
    $products = array();

    if ($product_rows) {
        $index = 0;
        //if query was successful, fill the users array
        while($row = mysqli_fetch_array($product_rows)) {
            $products[$index]["ProductId"] = $row["ProductId"];
            $products[$index]["ProductName"] = $row["ProductName"];
            $products[$index]["ProductDescription"] = $row["ProductDescription"];
            $products[$index]["ProductCost"] = $row["ProductCost"];
            $products[$index]["Quantity"] = $row["Quantity"];
            $index++;

            
        }
    }

    return $products;
}

function get_product_name($product_id)
{
    $product = get_product($product_id);

    if ($product && $product->num_rows === 1)
    {
        $product_info = mysqli_fetch_assoc($product);
        return $product_info["ProductName"];
    }
    else
    {
        return "No such product or multiple products found.";
    }
}

?>