<!DOCTYPE html>
<html>
<head>
    <title>Thank You</title>
</head>
<body>
    <h1>Order History</h1>

    <?php
    session_start();
    require_once("dbcontroller.php");
    $db_handle = new DBController();

    // Check if the user is logged in
    if (isset($_SESSION['loggedin'])) {
        $username = $_SESSION['loggedin']['username'];

        // Fetch orders for the logged-in user
        $order_query = "SELECT order_id, order_date, product_list, total_amount, indirizzo FROM orders inner join userlist on user_id = username WHERE user_id = ?";
        $stmt = $db_handle->prepare($order_query);

        if ($stmt) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo '<table border="1">';
                echo '<tr><th>Order ID</th><th>Order Date</th><th>Shipping Address</th><th>Product List</th><th>Total Amount</th></tr>';

                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $row['order_id'] . '</td>';
                    echo '<td>' . $row['order_date'] . '</td>';
                    echo '<td>'. $row['indirizzo'] . '</td>';
                    echo '<td>' . $row['product_list'] . '</td>';
                    echo '<td>' . $row['total_amount'] . '</td>';
                    echo '</tr>';
                }

                echo '</table>';
            } else {
                echo 'No orders found.';
            }
        } else {
            echo 'Error in database query.';
        }

        $stmt->close();
    } else {
        echo 'You are not logged in. Please log in to view your order history.';
    }
    ?>

    <br>
    <a href="Cliente_no_ui.php">Back to Shopping</a>
</body>
</html>