<?php

require_once("user.php");

class Room extends User{
    public function show(){
        $conn=parent::getconn();
        $token=$_COOKIE['token'];
        $sql1="SELECT * FROM `user` WHERE token='$token' ";
        $user_row=$conn->query($sql1);
        if($user_row->num_rows>0){
            global $user;
            global $reg;
            $user=$user_row->fetch_assoc();
            $roll=$user["rollno"];
            $sql2="SELECT * FROM `register` WHERE rollno='$roll'";
            $reg_row=$conn->query($sql2);
            if($reg_row->num_rows>0){
                $reg=$reg_row->fetch_array();
            }
        } else{
            die("Query Failed");
        }
    }
}

$obj=new Room();
$obj->show();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Details</title>
    <link rel="stylesheet" href="bootstrap-5.3.0-alpha1-dist/css/bootstrap.min.css">
    <style>
        html,body{
            position: relative;
            height: 100%;
            width: 100%;
            overflow: auto;
            background: url("study.jpg") center no-repeat;
            background-size: cover;
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

        input[type="radio"]{
            outline: solid 1px #6c757d;
            opacity: 0.5;
        }
    </style>
</head>
<body>
    <div class="container">
        <h5>Room Details</h5>
        <div class="row">
            <div class="col-md-8 mx-auto mt-5">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-hover table-responsive table-striped">
                            <tbody>
                                <h5 class="text-center text-primary">Room Details</h5>
                                <tr>
                                    <th>Roll No</th>
                                    <td><?php echo $user['rollno']; ?></td>
                                    <th>Applying Date</th>
                                    <td><?php echo $reg['stay_from']; ?></td>
                                </tr>
                                <tr>
                                    <th>Room No</th>
                                    <td><?php echo $reg['room_no'];?></td>
                                    <th>Fees PM</th>
                                    <td>2000</td>
                                </tr>
                                <tr>
                                    <th>Seater</th>
                                    <td>6</td>
                                    <th>Food Status</th>
                                    <td><?php echo $reg['food'];?> Food</td>
                                </tr>
                                <tr>
                                    <th>Stay From</th>
                                    <td><?php echo $reg['stay_from']; ?></td>
                                    <th>Duration</th>
                                    <td><?php echo $reg['duration']; ?> Month</td>
                                </tr>
                                <tr>
                                    <th>Hostel Fees</th>
                                    <td><?php echo $reg['duration'] * 9000; ?></td>
                                    <th>Food Fees</th>
                                    <td><?php echo $reg['food_duration'] * 2500; ?></td>
                                </tr>
                                <tr>
                                    <th>Total Fees</th>
                                    <td><?php echo ($reg['duration'] * 9000) + ($reg['food_duration'] * 2500) ; ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <table  class="table table-hover table-responsive table-striped">
                            <tbody>
                                <tr>
                                    <h5 class="text-center text-primary">Pesonal Details</h5>
                                </tr>
                                <tr>
                                    <th>Roll No</th>
                                    <td><?php echo $user['rollno']; ?></td>
                                    <th>Name</th>
                                    <td><?php echo $user['name']; ?></td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td><?php echo $user['email']; ?></td>
                                    <th>Contact No</th>
                                    <td><?php echo $user['phone']; ?></td>
                                </tr>
                                <tr>
                                    <th>Gender</th>
                                    <td><?php echo $user['genter']; ?></td>
                                    <th>Course</th>
                                    <td><?php echo $user['class']; ?></td>
                                </tr>
                                <tr>
                                    <th>Guardian Name</th>
                                    <td><?php echo $reg['gname']; ?></td>
                                    <th>Guardian Relation</th>
                                    <td><?php echo $reg['grelation']; ?></td>
                                </tr>
                                <tr>
                                    <th>Emergency No</th>
                                    <td><?php echo $reg['emergency']; ?></td>
                                    <th>Guardian No</th>
                                    <td><?php echo $reg['gnumber']; ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table table-hover table-responsive table-striped">
                            <tbody>
                                <tr>
                                    <h5 class="text-center text-primary">Address</h5>
                                </tr>
                                <tr>
                                    <th>City</th>
                                    <td><?php echo $user['city']; ?></td>
                                    <th>ZipCode</th>
                                    <td><?php echo $user['zipcode']; ?></td>
                                </tr>
                                <tr>
                                    <th>State</th>
                                    <td><?php echo $user['state']; ?></td>
                                    <th>Address</th>
                                    <td><?php echo $user['address']; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="bootstrap-5.3.0-alpha1-dist/js/bootstrap.min.js"></script>
</body>
</html>