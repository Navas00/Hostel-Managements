<?php

require_once "user.php";

class Dashboard extends User{

    public function checkauth(){
        $conn=parent::getconn();
        $cuser=empty($_COOKIE['user']) ? "null" : $_COOKIE['user'];
        $ctoken=empty($_COOKIE['token']) ? "null" :  $_COOKIE['token'];
        if($cuser == "null" or $ctoken == "null"){
            header("Location: student_login.php");
            die();
        }
        if(isset($_COOKIE['user']) and isset($_COOKIE['token'])){
            $stmt=$conn->prepare("SELECT name,email,token FROM user WHERE email=? AND token=?");
            $stmt->bind_param("ss",$cuser,$ctoken);
            $stmt->execute();
            $res=$stmt->get_result();
            global $row;
            $row=$res->fetch_assoc();
            $dbemail=empty($row['email']) ? "null" : $row['email'];
            $dbtoken=empty($row['token']) ? "null" : $row['token'];
            if($dbemail != "null" and $dbtoken != "null"){
                if($dbemail == $_COOKIE['user'] and $dbtoken == $row['token']){
                    //
                } else{
                    header("Location: student_login.php");
                }
            } else{
                header("Location: student_login.php");
                die();
            }
        }
    }

    public function getfees(){
        $conn=parent::getconn();
        $token=mysqli_real_escape_string($conn,$_COOKIE['token']);
        $res=$conn->query("SELECT rollno FROM user WHERE token='$token'");
        $row=$res->fetch_assoc();
        global $rollno;
        $rollno=$row['rollno'];
        $fees=$conn->query("SELECT FORMAT(fees,'C') AS fees,room_no FROM register WHERE rollno='$rollno'");
        $res1=$fees->fetch_assoc();
        global $frow;
        global $roomno;
        $roomno=$res1['room_no'];
        $frow=$res1['fees'];
    }

    public function roommate(){
        $conn=parent::getconn();
        $room=$GLOBALS['roomno'];
        global $mate;
        $mate=$conn->query("SELECT user.name,user.phone,user.class,register.room_no FROM user,register WHERE user.rollno = register.rollno AND register.room_no = '$room'");
    }

    public function chkvacate(){
        $conn=parent::getconn();
        $tok=mysqli_real_escape_string($conn,$_COOKIE['token']);
        $res=$conn->query("SELECT * FROM vacate WHERE token='$tok' ");
        global $req;
        if($res->num_rows > 0){
            $req = true;
        }
    }

    public function detail(){
        $conn = parent::getconn();
        global $data;
        $data=array();
        $sql = "SELECT COUNT(name) AS data FROM staff UNION SELECT COUNT(room_id) FROM room UNION SELECT COUNT(name) FROM user;";
        $res= $conn->query($sql);
        while($row = $res->fetch_assoc()){
            array_push($data,$row['data']);
        }
    }
}


$ob=new Dashboard();
$ob->checkauth();
$ob->getfees();
$ob->roommate();
$ob->chkvacate();
$ob->detail();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="bootstrap-5.3.0-alpha1-dist/css/bootstrap.min.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="dashboard_test.css" />
    <style>
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
    <title>Bootstap 5 Responsive Admin Dashboard</title>
</head>

<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase border-bottom"><img src="logo.jpg" alt="logo" style="height: 90px; width: 90px; border-radius: 10px;">WANDERLUST</div>
            <div class="list-group list-group-flush my-3">
                <a href="#" onclick="window.location.reload()" class="list-group-item list-group-item-action bg-transparent second-text active"><i
                        class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                <a href="vacate.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold <?php if($GLOBALS['req'] == true) echo "disabled";  ?>"><i
                        class="fas fa-people-carry me-2"></i>Vacate Room <span id="vstatus"></span></a>
                <a href="#" id="inb" style="display: none;" onclick="showmsg()" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fas fa-envelope me-2"></i>Inbox<span id="nnum"></span></a>
                <a href="room-detail.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fas fa-bed me-2"></i>Room Detail</a>
                <a href="menu.html" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                            class="fas fa-utensils me-2"></i>Meal Menu</a>
                <a href="detail.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fas fa-user me-2"></i>Profile</a>
                <a href="change-password.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fas fa-edit me-2"></i>Change Password</a>
                <a href="#" onclick="logout()" class="list-group-item list-group-item-action bg-transparent text-danger fw-bold"><i
                        class="fas fa-sign-out-alt me-2"></i>Log Out</a>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

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
                                <i class="fas fa-user me-2"></i><?php echo htmlentities($GLOBALS['row']['name']) ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="detail.php">Profile</a></li>
                                <li><a class="dropdown-item" onclick="logout()" id="logout" href="#">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="container-fluid px-4">
                <div class="row g-3 my-2">
                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                            <div>
                                <h3 class="fs-2"><?php echo($GLOBALS['data'][2]) ?></h3>
                                <p class="fs-5">Total Student</p>
                            </div>
                            <i class="fas fa-users fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                            <div>
                                <h3 class="fs-2"><?php echo($GLOBALS['data'][1]) ?></h3>
                                <p class="fs-5">Total Rooms</p>
                            </div>
                            <i
                                class="fas fa-bed fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                            <div>
                                <h3 class="fs-2"><?php echo($GLOBALS['data'][0]) ?></h3>
                                <p class="fs-5">Total Staff</p>
                            </div>
                            <i class="fas fa-user fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                            <div>
                                <h3 class="fs-2"><?php echo $frow; ?></h3>
                                <p class="fs-5">Total Fees</p>
                            </div>
                            <i class="fas fa-rupee-sign fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                        </div>
                    </div>
                </div>
                <div class="my-4">
                    <h4>Your Room Mates</h4>
                    <div class="card">
                        <div class="card-body">
                        <div class="inbox"></div>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Class</th>
                                    <th>Phone Number</th>
                                </tr>
                            </thead>
                        <tbody>
                            <?php
                            static $id=1;
                             while($row=$mate->fetch_assoc()){
                                echo "<tr>
                                <td>".$id."</td>
                                <td>".htmlentities($row['name'])."</td>
                                <td>".htmlentities($row['class'])."</td>
                                <td>".htmlentities($row['phone'])."</td>
                                </tr>";
                                $id++;
                             }
                            ?>
                        </tbody>
                    </table>
                        </div>
                    </div>
                </div>
                <div class="row my-5">
                    <h3 class="fs-4 mb-3">Report Complient</h3>
                    <div class="col">
                        <form action="user.php" method="post">
                        <div class="mb-3">
                            <textarea style="resize: none;" name="report" placeholder="Any Complient?" id="com" rows="3" class="form-control"></textarea>
                        </div>
                        <div class="d-grid w-25">
                            <button class="btn btn-primary" name="report">Report</button>
                        </div>
                        </form>
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

        $.post("check-vacate.php",{
            chksts : "none"
        },function(data,status){
            $("#nnum").html(data);
            $("#inb").attr("style","display:inline-block");
        })

        function logout(){
            $.post("user.php",{
                logout : "true"
            },function(data,status){
                window.location="student_login.php";
            })
        }


        function showmsg(){
            $.post("check-vacate.php",{
                chkinb : "none"
            },function(data,status){
                $(".col-md-3").attr("style","display:none");
                $("table").attr("style","display:none");
                $("h3").attr("style","display:none");
                $("h4").attr("style","display:none");
                $("textarea").attr("style","display:none");
                $("#report").attr("style","display:none");
                $(".inbox").html(data);
            })
        }

    </script>
</body>

</html>