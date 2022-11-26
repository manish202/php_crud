<?php 
    include "part.php";
    if(!isset($_POST['update']) && (empty($_GET['sid']) || !is_numeric($_GET['sid']))){header("Location: index.php");}
    $conn = mysqli_connect("localhost","root","","basic_crud");
    if($err = mysqli_connect_error()){
        die($err);
    }
    if(isset($_POST['update']) && isset($_POST['sid']) && !empty($_POST['sname']) && !empty($_POST['saddress']) && !empty($_POST['sclass']) && !empty($_POST['sphone'])){
        $sname = mysqli_real_escape_string($conn,$_POST['sname']);
        $saddress = mysqli_real_escape_string($conn,$_POST['saddress']);
        $sclass = mysqli_real_escape_string($conn,$_POST['sclass']);
        $sphone = mysqli_real_escape_string($conn,$_POST['sphone']);
        $sid = mysqli_real_escape_string($conn,$_POST['sid']);
        $sql = "UPDATE students SET sname = '$sname',saddress = '$saddress',sclass = $sclass,sphone = '$sphone' WHERE sid = $sid";
        $ans = mysqli_query($conn,$sql);
        if($err = mysqli_error($conn)){die($err);}
        if($ans){
            echo "<div class='alert alert-success'>update success!</div>";
        }else{
            echo "<div class='alert alert-danger'>update fail!</div>";
        }
        die();
    }
    $sid = mysqli_real_escape_string($conn,$_GET['sid']);
    $data2 = mysqli_query($conn,"SELECT * FROM students WHERE sid = $sid");
    if($err = mysqli_error($conn)){die($err);}
    if(mysqli_num_rows($data2) == 1){
        $res = mysqli_fetch_assoc($data2);
        $sname = $res['sname'];
        $saddress = $res['saddress'];
        $sphone = $res['sphone'];
        $sclass = $res['sclass'];
    }else{
        header("Location: index.php");
    }
?>
        <h2 class="text-capitalize p-3">update record</h2>
        <form autocomplete="off" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="w-50 m-auto bg-light p-3 text-capitalize" method="post">
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="sname" value="<?php echo $sname; ?>" required>
                    <input type="hidden" name="sid" value="<?php echo $sid; ?>">
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">address</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="saddress" value="<?php echo $saddress; ?>" required>
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
                                $selected = ($data['cid'] == $sclass)? "selected":"";
                                echo "<option $selected value='{$data['cid']}'>{$data['cname']}</option>";
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
                    <input type="text" class="form-control" name="sphone" value="<?php echo $sphone; ?>" required>
                </div>
            </div>
            <input type="submit" class="btn btn-dark d-block" value="update" name="update">
        </form>
    </div>
</body>
</html>