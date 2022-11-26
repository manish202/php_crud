<?php 
    include "part.php";
    $conn = mysqli_connect("localhost","root","","basic_crud");
    if($err = mysqli_connect_error()){
        die($err);
    }
    if(isset($_POST['save']) && !empty($_POST['sname']) && !empty($_POST['saddress']) && !empty($_POST['sclass']) && !empty($_POST['sphone'])){
        $sname = mysqli_real_escape_string($conn,$_POST['sname']);
        $saddress = mysqli_real_escape_string($conn,$_POST['saddress']);
        $sclass = mysqli_real_escape_string($conn,$_POST['sclass']);
        $sphone = mysqli_real_escape_string($conn,$_POST['sphone']);
        $sql = "INSERT INTO students(sname,saddress,sclass,sphone) VALUES('$sname','$saddress',$sclass,'$sphone')";
        $ans = mysqli_query($conn,$sql);
        if($err = mysqli_error($conn)){die($err);}
        if($ans){
            echo "<div class='alert alert-success'>success!</div>";
        }else{
            echo "<div class='alert alert-danger'>fail!</div>";
        }
    }
?>
        <h2 class="text-capitalize p-3">add new record</h2>
        <form autocomplete="off" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="w-50 m-auto bg-light p-3 text-capitalize" method="post">
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="sname" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">address</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="saddress" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">class</label>
                <div class="col-sm-10">
                    <select class="form-select" name="sclass" required>
                    <?php
                        $r1 = mysqli_query($conn,"SELECT * FROM student_class");
                        if($err = mysqli_error($conn)){die($err);}
                        if(mysqli_num_rows($r1) > 0){
                            echo "<option selected disabled>select class</option>";
                            while($data = mysqli_fetch_assoc($r1)){
                                echo "<option value='{$data['cid']}'>{$data['cname']}</option>";
                            }
                        }else{
                            echo "<option disabled>no records found</option>";
                        }
                        mysqli_close($conn);
                    ?>  
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">phone</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="sphone" required>
                </div>
            </div>
            <input type="submit" class="btn btn-dark d-block" value="save" name="save">
        </form>
    </div>
</body>
</html>