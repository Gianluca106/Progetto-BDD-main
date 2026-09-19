<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure the form was submitted as a POST request

    require_once("dbcontroller.php");
    $db_handle = new DBController();

    if (isset($_SESSION['loggedin']) && isset($_POST['product_id'], $_POST['quantity'])) {
        $product_id = $_POST['product_id'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];

        // Example: Insert into a shopping cart session
        $_SESSION['cart_item'][$product_id] = array('product_id' => $product_id,'quantity' => $quantity,'price' => $price);

        // Redirect back to the product page or perform any necessary actions
        header("Location: Cliente_no_ui.php"); // Replace with the correct URL
        exit;
    } else {
    }
}
?>