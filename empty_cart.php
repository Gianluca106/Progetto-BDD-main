<?php
session_start();
// Clear the cart data
unset($_SESSION['cart_item']);
// Redirect back to the cart view or any other page
header("Location: Cliente_no_ui.php"); // Change to your actual cart view page
?>