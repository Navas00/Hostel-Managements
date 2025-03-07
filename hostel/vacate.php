<?php

require_once "user.php";

if(session_status() == PHP_SESSION_ACTIVE){
    //
} else{
    session_start();
}

if(!isset($_SESSION['csrf_token'])){
    $_SESSION['csrf_token']=bin2hex(random_bytes(32));
}

class Avail extends User{
    public function showroom(){
        global $room;
        $room=array();
        $conn=parent::getconn();
        $sql=("SELECT room_id,available FROM `room` WHERE available>0");
        $result=$conn->query($sql);
        if($result->num_rows >0){
            while($row=$result->fetch_assoc()){
                array_push($room,$row['room_id']);
            }
        }
    }
}

$obj=new Avail();
$obj->showroom();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap-5.3.0-alpha1-dist/css/bootstrap.min.css">
    <title>Vacate Room</title>
    <style>
        html,body{
            position: relative;
            height: 100%;
            width: 100%;
            overflow: auto;
            background: url("study.jpg") center no-repeat;
            background-size: cover;
        }

        .card,input{
            background-color: #ddd;
        }
        body::before{
            content: '';
            position: absolute;
            height: 880px;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background-image: linear-gradient(to right bottom,#000,#000);
            opacity: 0.6;
        }
    </style>
</head>
<body>
    <div class="container">
            <div class="row">
                <div class="col-md-6 mx-auto mt-5">
                    <div id="card" class="card mt-5">
                        <div class="card-body mt-5">
                            <?php
                            global $alert;
                            $alert=empty($_GET['submit']) ? "null" : $_GET['submit'];
                            if($alert != "null" and $alert == 1){
                            echo "<div class=\"alert alert-success alert-dismissible fade show\">
                            <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                            <h4 class=\"text-center\">Your Request is Submitted!</h4>
                            <h6 class=\"text-center\">Manager Will Make The Desicion</h6>
                            </div>";
                            }
                            if(isset($_GET['csrf'])){
                                echo "<div class=\"alert alert-danger alert-dismissible fade show\">
                                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                                <h4 class=\"text-center\">Invalid CSRF Token</h4>
                                </div>";
                        }
                                ?>
                            <h4 id="vacate" class="text-center">VACATE ROOM</h4>
                            <form action="user.php" method="post" id="hideme" novalidate>
                                <div class="mb-3">
                                    <label for="room" class="form-label">Room To Vacate</label>
                                    <select name="roomno" id="rmno" class="form-select" required>
                                        <option selected>--Select Room--</option>
                                        <?php
                                         for($i=0;$i<count($room);$i++){
                                            echo "<option value=".$room[$i].">".$room[$i]."</option>";
                                         }
                                         ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        <p>Enter Your Vacate Room No</p>
                                    </div>
                                    <div class="mb-3">
                                        <label for="reason" class="form-label">Reason For Vacate</label>
                                        <textarea minlength="50" style="resize: none;" name="reason" id="reason" rows="5" class="form-control" required></textarea>
                                        <input type="hidden" name="_csrf" value="<?php echo $_SESSION['csrf_token']; ?>">
                                            <div class="invalid-feedback">
                                                <p>Reason For Vacate</p>
                                            </div>
                                    </div>
                                    <div class="mb-3 mt-4">
                                        <div class="d-grid">
                                            <button name="vacate" class="btn btn-primary">Send</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <script src="bootstrap-5.3.0-alpha1-dist/js/bootstrap.min.js"></script>
    <script>
        'use strict';
        var form=document.querySelectorAll("form");
        Array.from(form).forEach( form =>{
            form.addEventListener("submit",event =>{
                if(!form.checkValidity()){
                    event.stopPropagation();
                    event.preventDefault();
                }
                form.classList.add("was-validated");
            })
        })

        var query=window.location.search.substring(1);
        var param=query.split("=");
        if(param[1] == 1){
            var form=document.getElementById("hideme");
            var v=document.getElementById("vacate");
            form.style.display= "none";
            v.style.display= "none";
        }
    </script>
</body>
</html>