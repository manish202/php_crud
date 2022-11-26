<?php include "part.php"; ?>
        <h2 class="text-capitalize p-3">all records</h2>
        <table class="table text-center table-hover text-capitalize">
            <thead>
                <tr>
                    <th>id</th>
                    <th>name</th>
                    <th>address</th>
                    <th>class</th>
                    <th>phone</th>
                    <th>action</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $conn = mysqli_connect("localhost","root","","basic_crud");
                if($err = mysqli_connect_error()){
                    die($err);
                }else{
                    $sql = "SELECT * FROM students s JOIN student_class sc ON s.sclass = sc.cid";
                    $result = mysqli_query($conn,$sql);
                    if($err = mysqli_error($conn)){
                        die($err);
                    }else{
                        if(mysqli_num_rows($result) > 0){
                            while($rows = mysqli_fetch_assoc($result)){
                                echo "<tr>
                                <td>{$rows['sid']}</td>
                                <td>{$rows['sname']}</td>
                                <td>{$rows['saddress']}</td>
                                <td>{$rows['cname']}</td>
                                <td>{$rows['sphone']}</td>
                                <td><a href='update.php?sid={$rows['sid']}' class='btn btn-success mx-2 text-capitalize'>edit</a><a href='delete.php?sid={$rows['sid']}' class='btn btn-danger text-capitalize'>delete</a></td>
                            </tr>";
                            }
                        }else{
                            echo "<tr><td colspan='6'>no records found.</td></tr>";
                        }
                    }
                }
                mysqli_close($conn);
            ?>
            </tbody>
        </table>
    </div>
</body>
</html>