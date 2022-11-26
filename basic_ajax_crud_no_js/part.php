<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>basic crud operation date 18/06/2022</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css_js/color.css">
</head>
<body>
    <div class="container box">
        <h1>php basic crud No javascript or jquery</h1>
        <nav class="navbar navbar-dark bg-dark navbar-expand-sm">
            <div class="container-fluid">
                <ul class="navbar-nav">
                <?php
                    $bname = basename($_SERVER['PHP_SELF']);
                    $arr = [
                        "index.php" => "home",
                        "add.php" => "add",
                        "update.php" => "update",
                        "delete.php" => "delete"
                    ]; 
                    foreach($arr as $key => $val){
                        $active = ($bname == $key) ? "active" : "";
                        echo "<li class='nav-item text-uppercase'>
                        <a class='nav-link $active' href='$key'>$val</a>
                    </li>";
                    }
                ?>
                </ul>
            </div>
        </nav>