<?php

require_once "db.php";

class Checkadmin extends Admindb{
    public function checkad(){
        $conn=parent::getconn();
        $user=empty($_COOKIE['username']) ? "null" : $_COOKIE['username'];
        $token=empty($_COOKIE['token']) ? "null" : $_COOKIE['token'];
        if($user != "null" and $token != "null"){
            $token=mysqli_real_escape_string($conn,$_COOKIE['token']);
            $stmt=$conn->prepare("SELECT * FROM admin WHERE token=?");
            $stmt->bind_param("s",$token);
            $stmt->execute();
            $res=$stmt->get_result();
            global $row;
            $row=$res->fetch_assoc();
            $dbvalid=empty($row['is_valid']) ? "null" : $row['is_valid'];
            $dbtoken=empty($row['token']) ? "null" : $row['token'];
            if($dbvalid != "null" and $dbtoken != "null"){
                if($dbvalid == 1 and $dbtoken == $token){
                    //
                } else{
                    header("Location: glass_login.php");
                }
            } else{
                header("Location: glass_login.php");
            }
        } else{
            header("Location: glass_login.php");
        }
    }

    public function general(){
        $conn=parent::getconn();
        $sql="SELECT COUNT(*) AS cstaff FROM staff;";
        $sql .="SELECT COUNT(*) AS cuser FROM user;";
        $sql .="SELECT COUNT(*) AS croom FROM room;";
        $sql .="SELECT FORMAT(SUM(fees),0) AS tfees FROM room";
        global $data;
        $data=array();
        if($conn->multi_query($sql)){
            do{
                if($res=$conn->store_result()){
                    while($row=$res->fetch_assoc()){
                        array_push($data,$row);
                    }
                    $res->free_result();
                }
            } while($conn->next_result());
        }
    }
}

$ob=new Checkadmin();
$ob->checkad();
$ob->general();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="bootstrap-5.3.0-alpha1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="dashboard_test.css" />
    <title>Bootstap 5 Responsive Admin Dashboard</title>
    <style>
        .arrow{
            position: absolute;
            right: 0;
            margin-top: 5px;
            margin-right: 20px;
        }
        .icon-button {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            color: #333333;
            background: #ddd;
            border: none;
            outline: none;
            border-radius: 50%;
        }
        .icon-button:hover {
            cursor: pointer;
        }

.icon-button:active {
  background: #cccccc;
}

.icon-button__badge {
  position: absolute;
  top: -10px;
  right: -10px;
  width: 25px;
  height: 25px;
  background: red;
  color: #ffffff;
  display: flex;
  justify-content: center;
  align-items: center;
  border-radius: 50%;
}

#nnum{
    position: absolute;
    background-color: red;
    width: 20px;
    margin-left: 10px;
    border-radius: 50%;
    text-align: center;
    color: #ffffff;
}

    </style>
</head>

<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase border-bottom"><img src="logo.jpg" alt="logo" style="height: 90px; width: 90px; border-radius: 10px;">WANDERLUST</div>
            <div class="list-group list-group-flush my-3" style="cursor: pointer;">
                <a onclick="window.location.reload()" class="list-group-item list-group-item-action bg-transparent second-text active"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                <a onclick="showmsg();showgst()" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i class="fas fa-envelope me-2"></i>Inbox<span id="nnum">0</span></a>
                <a href="#" onclick="get_student()" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i class="fas fa-check-square me-2"></i>Student</a>
                        <!-- submenu-->
                <a href="#" style="transition: 0.5s;" onclick="showroom()" class="d-inline-block list-group-item list-group-item-action bg-transparent second-text fw-bold"><i class="fas fa-bed me-2"></i>Room<i id="arrow" class="d-inline-block fas fa-angle-right arrow"></i></a>
                        <div id="sub-room" class="d-none">
                        <a href="add-room.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">Add Room</a>
                        <a href="#" onclick="manageroom()" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">Manage Room</a>
                        </div>
                        <!-- submenu end -->


                <a href="#" onclick="showstaff()" class="d-inline-block list-group-item list-group-item-action bg-transparent second-text fw-bold"><i class="fas fa-user me-2"></i>Staff<i id="sarrow" class="d-inline-block fas fa-angle-right arrow"></i></a>
                        <!-- submenu-->
                        <div class="sub-staff d-none" style="cursor: pointer;">
                            <a onclick="rstaff()" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">Add Staff</a>
                            <a onclick="managestaff()" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">Manage Staff</a>
                        </div>
                        <!-- submenu end -->


                <button onclick="logout()" class="list-group-item list-group-item-action bg-transparent text-danger fw-bold"><i
                        class="fas fa-sign-out-alt me-2"></i>Log Out</button>
            </div>
        </div>
        <!-- #sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                    <h2 class="fs-2 m-0">Dashboard</h2>
                </div>

                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle fw-bold" href="#" id="navbarDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user me-2"></i><?php echo htmlentities($row['username']); ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#">Profile</a></li>
                                <li><a class="dropdown-item" href="#">Settings</a></li>
                                <li><a class="dropdown-item" href="#">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="container-fluid px-4">
                <div class="row g-3 my-2">
                    <div class="inbox"></div>
                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                            <div>
                                <h3 class="fs-2"><?php echo $GLOBALS['data'][1]['cuser']?></h3>
                                <p class="fs-5">Student</p>
                            </div>
                            <i class="fas fa-users fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                            <div>
                                <h3 class="fs-2"><?php echo($GLOBALS['data'][2]['croom']) ?></h3>
                                <p class="fs-5">Rooms</p>
                            </div>
                            <i
                                class="fas fa-bed fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                            <div>
                                <h3 class="fs-2"><?php echo($GLOBALS['data'][0]['cstaff']) ?></h3>
                                <p class="fs-5">Staff</p>
                            </div>
                            <i class="fas fa-user fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                            <div>
                                <h3 class="fs-2"><?php echo($GLOBALS['data'][3]['tfees'])?></h3>
                                <p class="fs-5">Expenses</p>
                            </div>
                            <i class="fas fa-rupee-sign fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- /#page-content-wrapper -->
    </div>

    <script src="bootstrap-5.3.0-alpha1-dist/js/bootstrap.min.js"></script>
    <script src="bootstrap-5.3.0-alpha1-dist/jquery/jquery.min.js"></script>
    <script>
        var el = document.getElementById("wrapper");
        var toggleButton = document.getElementById("menu-toggle");

        toggleButton.onclick = function () {
            el.classList.toggle("toggled");
        };

        var url=window.location.search.substring(1);
        success="<div class=\"alert alert-success alert-dismissible fade show\"> \
                 <h4 class=\"text-center\">Data Is Updated!</h4> \
                 <h6 class=\"text-center\">Thank You!</h6> \
                 </div>";
        if(url == "update=1"){
            $(".col-md-3").attr("style","display:none");
            $("table").attr("style","display:none");
            $("h3").attr("style","display:none");
            $(".inbox").html(success);
            setTimeout(manageroom,2000);

        }

        if(url == "addstaff=true"){
            $(".col-md-3").attr("style","display:none");
            $("table").attr("style","display:none");
            $("h3").attr("style","display:none");
            $(".inbox").html(success);
            setTimeout(rstaff,2500);

        }
            if(url == "ds=true"){
            $(".col-md-3").attr("style","display:none");
            $("table").attr("style","display:none");
            $("h3").attr("style","display:none");
            $(".inbox").html(success);
            setTimeout(managestaff,2500);
        }

        if(url == "ups=true"){
            $(".col-md-3").attr("style","display:none");
            $("table").attr("style","display:none");
            $("h3").attr("style","display:none");
            $(".inbox").html(success);
            setTimeout(managestaff,2500);
        }

        if(url == "upstd=true"){
            $(".col-md-3").attr("style","display:none");
            $("table").attr("style","display:none");
            $("h3").attr("style","display:none");
            $(".inbox").html(success);
            setTimeout(get_student,2500);
        }

        function getnotification(){
            $.get("check-vacate.php?getmsg=1",function(data,status){
                 $("#nnum").html(data);
            })
        }

        getnotification();

        function logout(){
            $.post("db.php",{
                logout: "true"
            },function(data,status){
                window.location="http://127.0.0.1/login/glass_login.php";
            })
        }

        function upstaff(phone){
            $.post("db.php",{
                upstaff : true,
                phoneno : phone
            },function(data,status){
                $(".col-md-3").attr("style","display:none");
                $("table").attr("style","display:none");
                $("h3").attr("style","display:none");
                $(".inbox").html(data);
            })
        }
        function showroom(){
            if($("#sub-room").hasClass("d-none")){
                $("#sub-room").removeClass("d-none");
                $("#arrow").removeClass("fa-angle-right");
                $("#arrow").addClass("fa-angle-down");
            } else{
                $("#sub-room").addClass("d-none");
                $("#arrow").addClass("fa-angle-right");
                $("#arrow").removeClass("fa-angle-down");
            }
        }

        function showstaff(){
            if($(".sub-staff").hasClass("d-none")){
                $(".sub-staff").removeClass("d-none");
                $("#sarrow").removeClass("fa-angle-right");
                $("#sarrow").addClass("fa-angle-down");
            } else{
                $(".sub-staff").addClass("d-none");
                $("#sarrow").addClass("fa-angle-right");
                $("#sarrow").removeClass("fa-angle-down");
            }
        }

        function managestaff(){
            $.post("db.php",{
                mgstaff : true
            },function(data,status){
                $(".col-md-3").attr("style","display:none");
                $("table").attr("style","display:none");
                $("h3").attr("style","display:none");
                $(".inbox").html(data);
            })
        }

        function deletestaff(phone){
            $.post("db.php",{
                deletestaff : true,
                phoneno : phone
            },function(data,status){
               //
            })
        }

        function showmsg(){
            var html;
            $.get("check-vacate.php?data=1",function(data,status){
                $(".col-md-3").attr("style","display:none");
                $("table").attr("style","display:none");
                $("h3").attr("style","display:none");
                $(".inbox").html(data);
            })
        }

        function showgst(){
            var html;
            $.get("guest.php?data=1",function(data,status){
                $(".col-md-3").attr("style","display:none");
                $("table").attr("style","display:none");
                $("h3").attr("style","display:none");
                $(".inbox").html(data);
            })
        }

        function showdetail(tok){
            $.post("check-vacate.php",{
                view : "true",
                token : tok
            },function(data,status){
                $("ul").attr("style","display:none");
                $(".inbox").html(data);
            })
        }

        function editerow(room_id){
            $.post("db.php",{
                roomd : "true",
                room_no : room_id
            },function(data,status){
                $(".inbox").html(data);
            })
        }

        function accept(){
            toke=$("#token").val();
            rl=$("#rollnum").val();
            $.post("check-vacate.php",{
                status : "accept",
                tok : toke
            },function(data,status){
                $("#"+rl).attr("style","display:none");
                $(".inbox").html(data);
                getnotification();

            });
        }

        function reject(){
            toke=$("#token").val();
            rl=$("#rollnum").val();
            $.post("check-vacate.php",{
                status : "reject",
                tok : toke
            },function(data,status){
                $("#"+rl).attr("style","display:none");
                $(".inbox").html(data);
                getnotification();
            });
        }

        function deleterow(room){
            $.post("db.php",{
                deletetable : "true",
                room_id : room
            },function(data,status){
                manageroom();
            })
        }

        function dstudent(roll){
            $.post("db.php",{
                dstudent : "true",
                roll_no : roll
            },function(data,status){
                get_student();
            })
        }

        function manageroom(){
            $.post("db.php",{
                getroom : "true"
            },function(data,status){
                $(".col-md-3").attr("style","display:none");
                $("table").attr("style","display:none");
                $("h3").attr("style","display:none");
                $(".inbox").html(data);
            })
        }

        function rstaff(){
            $.post("db.php",{
                regstaff : "true"
            },function(data,status){
                $(".col-md-3").attr("style","display:none");
                $("table").attr("style","display:none");
                $("h3").attr("style","display:none");
                $(".inbox").html(data);
            })
        }

        function get_student(){
            $.post("db.php",{
                getstudent : "true"
            },function(data,status){
                $(".col-md-3").attr("style","display:none");
                $("table").attr("style","display:none");
                $("h3").attr("style","display:none");
                $(".inbox").html(data);
            })
        }

        function editstudent(rno){
            $.post("db.php",{
                estudent : "true",
                rollno : rno
            },function(data,status){
                $(".col-md-3").attr("style","display:none");
                $("table").attr("style","display:none");
                $("h3").attr("style","display:none");
                $(".inbox").html(data);
            })
        }
    </script>
</body>

</html>