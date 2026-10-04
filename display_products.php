<?php
    session_start();

    require_once('../controller/productinfo_controller.php');

    $product_arr = get_products();

    // Create an empty cart if one does not already exist.
    // The cart will store:
    // ProductId => Quantity
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    // Add product to cart
    if (isset($_POST['add_to_cart'])) {

        $productId = $_POST['product_id'];

        if (!isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId] = 1;
        } else {
            $_SESSION['cart'][$productId]++;
        }
    }

    // Remove product from cart completely
    if (isset($_POST['remove_from_cart'])) {

        $productId = $_POST['product_id'];

        unset($_SESSION['cart'][$productId]);
    }

    // Increase quantity
    if (isset($_POST['increase_quantity'])) {

        $productId = $_POST['product_id'];

        if (!isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId] = 1;
        } else {
            $_SESSION['cart'][$productId]++;
        }
    }

    // Decrease quantity
    if (isset($_POST['decrease_quantity'])) {

        $productId = $_POST['product_id'];

        if (isset($_SESSION['cart'][$productId])) {

            $_SESSION['cart'][$productId]--;

            // Never allow quantity to go below 0.
            if ($_SESSION['cart'][$productId] <= 0) {
                unset($_SESSION['cart'][$productId]);
            }
        }
    }
?>

<html>
    <head>
        <title>SDC310 Lab Project - Angel Avila</title>
        <link rel="stylesheet" href="styles.css">
    </head>

    <body>

        <h2>Current Products:</h2>

        <table>
            <tr style="font-size:large;">
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Product Description</th>
                <th>Product Cost</th>
                <th>Quantity in Cart</th>
                <th>Add</th>
                <th>Remove</th>
                <th>Quantity</th>
            </tr>

            <?php foreach ($product_arr as $product): ?>

                <?php
                    $productId = $product["ProductId"];

                    // Get the quantity currently in the cart.
                    // If the product is not in the cart, quantity is 0.
                    $cartQuantity = isset($_SESSION['cart'][$productId])
                        ? $_SESSION['cart'][$productId]
                        : 0;
                ?>

                <tr>

                    <td>
                        <?php echo $product["ProductId"]; ?>
                    </td>

                    <td>
                        <?php echo $product["ProductName"]; ?>
                    </td>

                    <td>
                        <?php echo $product["ProductDescription"]; ?>
                    </td>

                    <td>
                        <?php echo '$' . number_format($product["ProductCost"], 2); ?>
                    </td>

                    <td>
                        <?php echo $cartQuantity; ?>
                    </td>

                    <!-- Add to Cart -->
                    <td>
                        <form method="POST">

                            <input type="hidden"
                                name="product_id"
                                value="<?php echo $productId; ?>">

                            <input type="submit"
                                name="add_to_cart"
                                value="Add to Cart">

                        </form>
                    </td>

                    <!-- Remove from Cart -->
                    <td>
                        <form method="POST">

                            <input type="hidden"
                                name="product_id"
                                value="<?php echo $productId; ?>">

                            <input type="submit"
                                name="remove_from_cart"
                                value="Remove">

                        </form>
                    </td>

                    <!-- Increase / Decrease Quantity -->
                    <td>

                        <form method="POST" style="display:inline;">

                            <input type="hidden"
                                name="product_id"
                                value="<?php echo $productId; ?>">

                            <input type="submit"
                                name="decrease_quantity"
                                value="-">

                        </form>

                        <?php echo $cartQuantity; ?>

                        <form method="POST" style="display:inline;">

                            <input type="hidden"
                                name="product_id"
                                value="<?php echo $productId; ?>">

                            <input type="submit"
                                name="increase_quantity"
                                value="+">

                        </form>

                    </td>

                </tr>

            <?php endforeach; ?>

        </table>

        <br>

        <a href="find_product.php">Cart Page</a>

    </body>
</html>
