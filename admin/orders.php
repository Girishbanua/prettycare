<?php
// include "../includes/db.php"; // database
$stmnt = "SELECT * FROM orders"; // sql
$result = mysqli_query($conn, $stmnt); // execute the statement and store
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th>Customer Name</th>
                <th>Phone</th>
                <th>Address</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result)) { //associative arra
                $customer_name = $row['customer_name'];
                $phone = $row['phone'];
                $address = $row['address'];
                echo "
                    <tr> 
                     <td>$customer_name</td>
                     <td>$phone</td>
                     <td>$address</td>  
                    </tr>  
                    ";
            }
            ?>
        </tbody>
    </table>
</body>

</html>