<!DOCTYPE html>
<html>
<head>
<style>
body {
	font-family: Arial;
	color: #211a1a;
	font-size: 0.9em;
}

#shopping-cart {
	margin: 40px;
}

#product-grid {
    margin: 50px;
}

.product-item {
    float: left;
    background: #ffffff;
    margin: 40px 40px 0px 0px;
    border: #E0E0E0 1px solid;
    padding: 10px; /* Add some padding to separate product items */
}

/* Style for the Shopping Cart */
#shopping-cart {
    margin: 40px;
}

.tbl-cart {
    width: 100%;
    background-color: #F0F0F0;
    margin: 0; /* Remove any default margin to align it with the Product List */
}

.tbl-cart td {
    background-color: #FFFFFF;
    padding: 5px; /* Add padding to table cells for spacing */
    border-bottom: 1px solid #E0E0E0; /* Add a border between rows */
}


#shopping-cart table {
	width: 100%;
	background-color: #F0F0F0;
}

#shopping-cart table td {
	background-color: #FFFFFF;
}

.txt-heading {
	color: #211a1a;
	border-bottom: 1px solid #E0E0E0;
	overflow: auto;
}

#btnEmpty {
	background-color: #ffffff;
	border: #d00000 1px solid;
	padding: 5px 10px;
	color: #d00000;
	float: right;
	text-decoration: none;
	border-radius: 3px;
	margin: 10px 0px;
}

.btnAddAction {
    padding: 5px 10px;
    margin-left: 5px;
    background-color: #efefef;
    border: #E0E0E0 1px solid;
    color: #211a1a;
    float: right;
    text-decoration: none;
    border-radius: 3px;
    cursor: pointer;
}

#product-grid .txt-heading {
	margin-bottom: 18px;
}

.product-item {
	float: left;
	background: #ffffff;
	margin: 40px 40px 0px 0px;
	border: #E0E0E0 1px solid;
}

.product-image {
	height: 150px;
	width: 250px;
	background-color: #FFF;
}

.clear-float {
	clear: both;
}

.demo-input-box {
	border-radius: 2px;
	border: #CCC 1px solid;
	padding: 2px 1px;
}

.tbl-cart {
	font-size: 0.9em;
}

.tbl-cart th {
	font-weight: normal;
}

.product-title {
	margin-bottom: 20px;
}

.product-price {
	float:left;
}

.cart-action {
	float: right;
}

.product-quantity {
    padding: 5px 10px;
    border-radius: 3px;
    border: #E0E0E0 1px solid;
}


.product-tile-footer {
    padding: 15px 15px 0px 15px;
    overflow: auto;
}

.cart-item-image {
	width: 30px;
    height: 30px;
    border-radius: 50%;
    border: #E0E0E0 1px solid;
    padding: 5px;
    vertical-align: middle;
    margin-right: 15px;
}
.no-records {
	text-align: center;
	clear: both;
	margin: 38px 0px;
}
</style>
<link href="style.css" type="text/css" rel="stylesheet" />
</head>
<body>
<?php
session_start();
require_once("dbcontroller.php");
$db_handle = new DBController();
$product_array = $db_handle->runQuery("SELECT * FROM products ORDER BY id ASC");
$cart_total = 0;
if (!empty($product_array)) {
?>
<div id="product-grid">
    <div class="txt-heading">Products</div>
    <?php
    foreach ($product_array as $key => $product) {
        ?>
        <div class="product-item">
            <form method="post" action="purchase.php">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
				<input type="hidden" name="price" value="<?php echo $product['price']; ?>">
                <div class="product-image"><img width="150" height="auto" src="<?php echo $product['image']; ?>"></div>
                <div class="product-tile-footer">
                    <div class="product-title"><?php echo $product['title']; ?></div>
                    <div class="product-price"><?php echo "$ " . $product['price']; ?></div><br>
                    <div class="product-in_stock"><?php echo "In Stock: " . $product['in_stock']; ?></div>
                    <div class="cart-action">
                        <input type="number" class="product-quantity" name="quantity" value="1" size="2" min="1" max="<?php echo $product['in_stock']; ?>" />
                        <input type="submit" value="Buy" />
                    </div>
                </div>
            </form>
        </div>
        <?php
    }
    ?>
</div>
<?php
}

// Cart view
if (isset($_SESSION['loggedin']) && isset($_SESSION['cart_item']) && !empty($_SESSION['cart_item'])) {
    ?>
    <div id="shopping-cart">
        <div class="txt-heading">Shopping Cart</div>
        <table class="tbl-cart" cellpadding="10" cellspacing="1">
            <tbody>
                <tr>
                    <th style="text-align:left;">Name</th>
                    <th style="text-align:right;">Quantity</th>
                    <th style="text-align:right;">Unit Price</th>
                    <th style="text-align:right;">Price</th>
                </tr>
                <?php
                foreach ($_SESSION['cart_item'] as $item) {
                    $item_price = (float)$item['quantity'] * (float)$item['price'];
                    $cart_total += $item_price;
                    ?>
                    <tr>
                        <td><?php echo $item['product_id']; ?></td>
                        <td style="text-align:right;"><?php echo $item['quantity']; ?></td>
                        <td style="text-align:right"><?php echo "$ " . $item['price']; ?></td>
                        <td style="text-align:right"><?php echo "$ " . number_format($item_price, 2); ?></td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td colspan="3" align="right"><strong>Total:</strong></td>
                    <td style="text-align:right"><?php echo "$ " . number_format($cart_total, 2); ?></td>
                </tr>
				<tr>
                <td colspan="4" align="right">
                    <form method="post" action="empty_cart.php">
                        <input type="submit" value="Empty Cart" class="btnEmpty" />
                    </form>
					<form method="post" action="checkout.php">
						<input type="submit" value="Send order" class="btnSend" />
					</form>
                </td>
				
            </tr>
            </tbody>
        </table>
    </div>
    <?php
} else {
    ?>
    <div class="no-records">Your Cart is Empty</div>
    <?php
}
?>
</body>
</html>