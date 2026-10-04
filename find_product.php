<?php
    session_start();

    require_once('../controller/productinfo_controller.php');

    // Create an empty cart if one does not exist.
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    /*
     * CHECKOUT
     *
     * When the user clicks Checkout:
     * 1. Empty the cart.
     * 2. Return to the product catalog.
     */
    if (isset($_POST['checkout'])) {

        $_SESSION['cart'] = array();

        header("Location: display_products.php");
        exit();
    }

    /*
     * Get all products from the database.
     */
    $product_arr = get_products();

    /*
     * Calculate cart totals.
     */
    $totalItems = 0;
    $pretaxTotal = 0;
?>

<html>

    <head>
        <title>SDC310 Lab Project - Angel Avila</title>
        <link rel="stylesheet" href="styles.css">
    </head>

    <body>

        <h2>Shopping Cart</h2>

        <table>

            <tr style="font-size:large;">
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Product Cost</th>
                <th>Product Total</th>
            </tr>

            <?php foreach ($product_arr as $product): ?>

                <?php

                    $productId = $product["ProductId"];

                    /*
                     * Only display products that are
                     * currently in the cart.
                     */
                    if (isset($_SESSION['cart'][$productId])) {

                        $quantity = $_SESSION['cart'][$productId];

                        /*
                         * Make sure quantity is greater than 0.
                         */
                        if ($quantity > 0) {

                            $productCost = $product["ProductCost"];

                            $productTotal = $quantity * $productCost;

                            $totalItems += $quantity;

                            $pretaxTotal += $productTotal;
                        }
                    }
                ?>

                <?php if (isset($_SESSION['cart'][$productId]) &&
                          $_SESSION['cart'][$productId] > 0): ?>

                    <tr>

                        <td>
                            <?php echo $productId; ?>
                        </td>

                        <td>
                            <?php echo $product["ProductName"]; ?>
                        </td>

                        <td>
                            <?php echo $_SESSION['cart'][$productId]; ?>
                        </td>

                        <td>
                            $<?php echo number_format($product["ProductCost"], 2); ?>
                        </td>

                        <td>
                            $<?php echo number_format($productTotal, 2); ?>
                        </td>

                    </tr>

                <?php endif; ?>

            <?php endforeach; ?>

        </table>

        <br>

        <?php

            /*
             * Calculate 5% tax.
             */
            $tax = $pretaxTotal * 0.05;

            /*
             * Shipping and handling is 10%
             * of the pretax total.
             */
            $shipping = $pretaxTotal * 0.10;

            /*
             * Final order total.
             */
            $orderTotal = $pretaxTotal + $tax + $shipping;

        ?>

        <h2>Order Summary</h2>

        <p>
            <strong>Total Items Ordered:</strong>
            <?php echo $totalItems; ?>
        </p>

        <p>
            <strong>Pretax Total:</strong>
            $<?php echo number_format($pretaxTotal, 2); ?>
        </p>

        <p>
            <strong>Tax (5%):</strong>
            $<?php echo number_format($tax, 2); ?>
        </p>

        <p>
            <strong>Shipping and Handling (10%):</strong>
            $<?php echo number_format($shipping, 2); ?>
        </p>

        <p>
            <strong>Order Total:</strong>
            $<?php echo number_format($orderTotal, 2); ?>
        </p>

        <br>

        <!-- Checkout -->
        <form method="POST">

            <input type="submit"
                   name="checkout"
                   value="Checkout">

        </form>

        <br>

        <a href="display_products.php">Continue Shopping</a>

    </body>

</html>
