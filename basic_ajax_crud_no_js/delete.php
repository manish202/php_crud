<?php 
    include "part.php";
    if(!isset($_POST['delete']) && (empty($_GET['sid']) || !is_numeric($_GET['sid']))){header("Location: index.php");}
    $conn = mysqli_connect("localhost","root","","basic_crud");
    if($err = mysqli_connect_error()){
        die($err);
    }
    if(isset($_POST['delete']) && isset($_POST['sid'])){
        $sid = mysqli_real_escape_string($conn,$_POST['sid']);
        $sql = "DELETE FROM students WHERE sid = $sid";
        $ans = mysqli_query($conn,$sql);
        if($err = mysqli_error($conn)){die($err);}
        if($ans){
            echo "<div class='alert alert-success'>delete success!</div>";
        }else{
            echo "<div class='alert alert-danger'>delete fail!</div>";
        }
        die();
    }
    if(!isset($_POST['delete'])){
        $sid = mysqli_real_escape_string($conn,$_GET['sid']);
    }else{$sid = "";}
?>
        <h2 class="text-capitalize p-3">delete record</h2>
        <form autocomplete="off" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="w-50 m-auto bg-light p-3 text-capitalize" method="post">
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">id</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="sid" value="<?php echo $sid; ?>" required>
                </div>
            </div>
            <input type="submit" class="btn btn-dark d-block" value="delete" name="delete">
        </form>
    </div>
</body>
</html>