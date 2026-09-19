<?php
session_start();
require_once("dbcontroller.php");


if (isset($_SESSION['loggedin']) && isset($_SESSION['cart_item']) && !empty($_SESSION['cart_item'])) {

    // Connect to the database
    $db = new DBController();

    //Get item_list
    $itemArray = array();
    $total_amount = 0;
    foreach ($_SESSION['cart_item'] as $item) {
        $product_id = $item['product_id'];
        $quantity = $item['quantity'];
        $price = $item['price'];
        $total_amount = $total_amount + ($price*$quantity);
        $itemArray[] = array('product_id' => $product_id, 'quantity' => $quantity);

        // Select the item
        $selectQuery = "SELECT id, in_stock FROM products WHERE id = ?";
        $selectStmt = $db->prepare($selectQuery);

        if ($selectStmt) {
            $selectStmt->bind_param("i", $product_id);
            $selectStmt->execute();
            $selectStmt->store_result();

            if ($selectStmt->num_rows > 0) {
                //item found
                $selectStmt->bind_result($product_id, $in_stock);
                $selectStmt->fetch();
                $newStockValue = $in_stock - $quantity;
                $selectStmt->free_result();

                // Item found, update the in_stock value
                
                $updateQuery = "UPDATE products SET in_stock = ? WHERE id = ?";
                $updateStmt = $db->prepare($updateQuery);

                if ($updateStmt) {
                    $updateStmt->bind_param("ii", $newStockValue, $product_id);
                    $success = $updateStmt->execute();

                    if ($success) {
                        echo "Stock updated successfully.";
                    } else {
                        echo "Failed to update stock.";
                    }

                    $updateStmt->close();
                } else {
                    echo "Failed to prepare the update query.";
                }
            } else {
                // Product with the given ID not found
                echo "Product not found.";
            }
        }
    }
    $itemList = serialize($itemArray);
    $insertOrderSQL = "INSERT INTO orders (user_id, order_date, product_list, total_amount) VALUES (?, NOW(),?,?)";

    if ($stmt = $db->prepare($insertOrderSQL)) {
        $user = $_SESSION['loggedin'];
        $stmt->bind_param("ssd", $user['username'],$itemList,$total_amount);
        $stmt->execute();

        $order_id = $stmt->insert_id;
        $stmt->close();

        // Clear the session cart
        unset($_SESSION['cart_item']);

        // Redirect the user to the thank you page
        header("Location: thankyou.php");
        exit();
    }
}
?>