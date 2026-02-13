<div>
    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
        </tr>

        <?php
        $stmnt = "SELECT * FROM users";
        $result = mysqli_query($conn, $stmnt);

        while ($row = mysqli_fetch_assoc($result)) {
            $name = $row['name'];
            $email = $row['email'];
            $role = $row['role'];

            echo "   <tr>
                 <td>$name</td>
                 <td>$email</td>
                 <td>$role</td></tr> ";
        }
        ?>

    </table>
</div>