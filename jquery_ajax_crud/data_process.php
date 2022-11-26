<?php
    $conn = mysqli_connect("localhost","root","","ajax_crud") or die(mysqli_connect_error());
    function load_data($where=""){
        global $conn;
        if(isset($_POST['page'])){
            $page = $_POST['page'];
        }else{
            $page = 1;
        }
        $limit = 5;
        $offset = ($page - 1)*$limit;
        $f = ($where != "")? "WHERE CONCAT(fname,lname) LIKE '%$where%'":"";
        $result = mysqli_query($conn,"SELECT * FROM students $f ORDER BY sid DESC LIMIT $offset,$limit") or die(mysqli_error($conn));
        if(mysqli_num_rows($result) > 0){
            $x = "<tbody>";
            while($row = mysqli_fetch_assoc($result)){
                $x .= "<tr data-fname='{$row['fname']}' data-lname='{$row['lname']}' data-id='{$row['sid']}'><td>{$row['sid']}</td><td>{$row['fname']}</td><td>{$row['lname']}</td><td><button class='btn mx-2 btn-success edit'>edit</button><button class='btn mx-2 btn-danger delete'>delete</button></td></tr>";
            }
            $x .= "</tbody>";
            $result2 = mysqli_query($conn,"SELECT COUNT(*) as total FROM students $f") or die(mysqli_error($conn));
            if(mysqli_num_rows($result2) > 0){
                $x1 = mysqli_fetch_assoc($result2);
                $total = $x1['total'];
                $total_page = ceil($total / $limit);
                $y = "<tfoot><tr><td colspan='6'><ul class='pagination mt-3 justify-content-center'>";
                if($page > 1){
                    $y .= "<li class='page-item'><button class='btn btn-light ajax-pagi' data-page='".($page - 1)."'>prev</button></li>";
                }
                for($i=1;$i <= $total_page;$i++){
                    $a = ($page == $i)? "btn-dark":"btn-light";
                    $y .= "<li class='page-item'><button class='btn $a ajax-pagi' data-page='$i'>$i</button></li>";
                }
                if($total_page > $page){
                    $y .= "<li class='page-item'><button class='btn btn-light ajax-pagi' data-page='".($page + 1)."'>next</button></li>";
                }
                $y .= "</ul></td></tr></tfoot>";
                echo $x." ".$y;
            }else{
                echo "no records found.";
            }
        }else{
            echo "<tbody><tr><td colspan='4'>no records found.</td></tr></tbody>";
        }
    }
    if(isset($_POST['target'])){
        if($_POST['target'] == "load"){
            load_data($_POST['term']);
        }elseif($_POST['target'] == "#add_data" || $_POST['target'] == "#edit_data"){
            if(empty($_POST['fname']) || empty($_POST['lname'])){
                echo "first name or last name is missing.";
            }elseif($_POST['target'] == "#edit_data" && empty($_POST['sid'])){
                echo "sid is missing.";
            }else{
                $fname = mysqli_real_escape_string($conn,$_POST['fname']);
                $lname = mysqli_real_escape_string($conn,$_POST['lname']);
                if($_POST['target'] == "#add_data"){
                    $sql = "INSERT INTO students(fname,lname) VALUES('$fname','$lname')";
                }else{
                    $sql = "UPDATE students SET fname = '$fname',lname = '$lname' WHERE sid = {$_POST['sid']}";
                }
                if(mysqli_query($conn,$sql)){
                    echo 1;
                }else{
                    echo mysqli_error($conn);
                }
            }
        }elseif($_POST['target'] == "delete"){
            if(empty($_POST['sid'])){
                echo "sid is missing.";
            }else{
                $sid = mysqli_real_escape_string($conn,$_POST['sid']);
                if(mysqli_query($conn,"DELETE FROM students WHERE sid = $sid")){
                    echo 1;
                }else{
                    echo mysqli_error($conn);
                }
            }
        }else{
            echo "target (".$_POST['target'].") is wrong.";
        }
    }else{
        echo "target is not set yet.";
    }

?>