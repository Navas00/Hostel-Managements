<?php

require_once "db.php";

class Checkauth extends Admindb{
    function isadmin(){
        $conn=parent::getconn();
        $user=empty($_COOKIE['username']) ? "null" : $_COOKIE['username'];
        if($user == "null"){
            header("Location: glass_login.php");
        }
        $token=$_COOKIE['token'];
        $stmt=$conn->prepare("SELECT * FROM admin where username=?");
        $stmt->bind_param("s",$user);
        $stmt->execute();
        $res=$stmt->get_result();
        $row=$res->fetch_assoc();
        $dbuser=empty($row['username']) ? "null" : $row['username'] ;
        $dbtoken=empty($row['token']) ? "null" : $row['token'];
        if($dbtoken != "null" and $dbuser != "null"){
            if($user == $dbuser and $token == $dbtoken and $row['is_valid'] == 1){
                //
            } else{
                header("Location: glass_login.php");
            }
        }
    }
}

$ob=new Checkauth();
$ob->isadmin();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Room</title>
    <link rel="stylesheet" href="bootstrap-5.3.0-alpha1-dist/css/bootstrap.min.css">
    <style>
        html,body{
            position: relative;
            height: 100%;
            width: 100%;
            overflow: auto;
            background: url("1674883249071.jpg") center no-repeat;
            background-size: cover;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 mx-auto mt-5">
                <form action="db.php" method="post">
                <div class="card mt-5">
                    <div id="fullcard" class="card-body mt-5">
                        <h5 class="text-center text-primary">Add A Room</h5>
                        <div class="mb-3">
                        <label for="seat" class="form-label">Select seater</label>
                        <select name="seatno" id="seat" class="form-select">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                        </div>
                        <div class="mb-3">
                            <label for="rn" class="form-label">Room Number</label>
                            <input type="text" name="room_id" id="rn" class="form-control">
                        </div>
                        <div class="mb-4">
                            <div class="d-grid">
                                <button name="addroom" class="btn btn-primary">Create Room</button>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>

<script src="bootstrap-5.3.0-alpha1-dist/js/bootstrap.min.js"></script>
<script>

    var url=window.location.search.substring(1);
    if(url == "success=1"){
        success();
    }
    if(url == "failed=1"){
        failed();
    }
    function success(){
        var sucess="<div class=\"alert alert-success alert-dismissible\"> \
        <h4 class=\"text-center\">Room Is Added</h4> \
        <h6 class=\"text-center\">Thank You!</h6> \
        </div>";
        var card=document.getElementById("fullcard");
        card.innerHTML=sucess;
    }

    function failed(){
        var fail="<div class=\"alert alert-danger alert-dismissible\"> \
        <h4 class=\"text-center\">Room Creation Is Failed</h4> \
        <h6 class=\"text-center\">Sorry!</h6> \
        </div>";
        var card=document.getElementById("fullcard");
        card.innerHTML=fail;
    }

    function showmsg(){
        
    }

</script>
</body>
</html>