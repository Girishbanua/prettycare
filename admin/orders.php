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
    <style>
        .order_container {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        input {
            width: 300px;
            text-align: right;
            border-radius: 10px;
            border: 1px solid #292929ff;
        }

        .actionBtns {
            display: flex;
            gap: 30px;
        }

        button {
            border: none;
            border-radius: 10px;
            cursor: pointer;
            color: white;
        }

        .delete {
            background-color: rgba(234, 68, 82, 1);
        }

        .cancel {
            background-color: rgba(231, 158, 41, 1);
        }

        .delivered {
            background-color: rgba(44, 201, 99, 1);
        }
    </style>
</head>

<body>
    <div class="order_container">

        <input type="text" placeholder="search the customer">
        <br> <br>
        <table>
            <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) { //associative arra
                    $customer_name = $row['customer_name'];
                    $phone = $row['phone'];
                    $address = $row['address'];
                    $status = $row['order_status'];
                    echo "
                    <tr> 
                     <td>$customer_name</td>
                     <td>$phone</td>
                     <td>$address</td>  
                     <td>$status</td>  
                     <td class='actionBtns'>
                        <button class='delete'>Delete</button>
                        <button class='cancel'>Cancel</button>
                        <button class='delivered'>Delivered</button>
                     </td>  
                    </tr>  
                    ";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>