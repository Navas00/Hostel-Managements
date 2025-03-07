<?php

require_once "user.php";

class Book extends User{
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

$obj=new Book();
$obj->showroom();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Hostel</title>
    <link rel="stylesheet" href="bootstrap-5.3.0-alpha1-dist/css/bootstrap.min.css">
    <style>
        html,body{
            position: relative;
            height: auto;
            width: 100%;
            background: url("study.jpg") center no-repeat;
            background-size: cover;
        }
        body::before{
            content: '';
            position: absolute;
            height: auto;
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
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card mt-5 mb-3">
                    <div class="card-body">
                        <form action="user.php" method="post" novalidate>
                            <h4 class="text-center">Book Hostel</h4>
                            <div class="mb-3">
                                <p class="text-primary mb-4 h6">Room Detail</p>
                                <label for="rmno" class="form-label">Room No</label>
                                    <select name="roomno" id="rmno" class="form-select" required>
                                        <option disabled selected value="">--Select Room--</option>
                                        <?php
                                         for($i=0;$i<count($room);$i++){
                                            echo "<option value=".$room[$i].">".$room[$i]."</option>";
                                         }
                                         ?>
                                    </select>
                                    <div class="invalid-feedback">
                                            <p>Select Room Number</p>
                                    </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Food Status</label>
                                <div class="form-check form-check-inline ps-5">
                                    <input type="radio" id="with" onclick="showmonth()" value="with" class="form-check-input" name="food" required>
                                    <label for="with" class="form-check-label">with food</label>
                                </div>
                                <div class="form-check form-check-inline ps-5">
                                    <input type="radio" value="without" onclick="hidemonth()" id="without" class="form-check-input" name="food" required>
                                    <label for="without" class="form-check-label">without food</label>
                                </div>
                            </div>
                            <div id="withfood" style="display: none;" class="mb-3">
                                <label for="fd" class="form-label">Food Duration<small class="text-muted">(2500/Month)</small></label>
                                <select name="fd" id="fd" class="form-select" required>
                                    <option disabled selected value="">--Select Duration--</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                </select>
                                <div class="invalid-feedback">
                                    <p>Select Option</p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="from" class="form-label">Stay From</label>
                                <input type="date" id="from" class="form-control" name="stayfrom" required>
                                <div class="invalid-feedback">
                                            <p>Select Date</p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="month" class="form-label">Duration</label>
                                <select class="form-select" name="duration" id="month" required>
                                    <option selected disabled value="">select duration in semester</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                </select>
                                <div class="invalid-feedback">
                                    <p>Select Duration</p>
                                </div>
                            </div>
                            <p class="text-primary h6">Personal Details</p>
                            <div class="mb-3">
                                <label for="rollno" class="form-label">Roll No</label>
                                <input type="number" placeholder="Roll no" id="rollno" name="rollno" class="form-control" required>
                                <div class="invalid-feedback">
                                    <p>Enter Roll number</p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="gname">Guardian Name</label>
                                <input type="text" id="gname" placeholder="Guardina Name" name="gname" class="form-control" required>
                                <div class="invalid-feedback">
                                    <p>Enter Guardian Name</p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="grealation">Guardian Relation</label>
                                <input type="text" id="grelation" placeholder="Guardina Relation" name="grelation" class="form-control" required>
                                <div class="invalid-feedback">
                                    <p>Enter Gender Relation</p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="gnum">Guardian Number</label>
                                <input type="number" id="gnum" placeholder="Phone Number" name="gnum" class="form-control" required>
                                <div class="invalid-feedback">
                                    <p>Enter Guardian number</p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="gnum">Emergency Contact No</label>
                                <input type="number" id="gnum" placeholder="Emergency No" name="emergency" class="form-control" required>
                                <div class="invalid-feedback">
                                    <p>Enter Emergency number</p>
                                </div>
                            </div>
                            <div class="mb-2">
                                <div class="d-grid mt-4 pb-3">
                                    <button name="book" class="btn btn-primary">Book</button>
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

        function showmonth(){
            var select=document.getElementById("withfood");
            select.style.display="grid";
        }

        function hidemonth(){
            var select=document.getElementById("withfood");
            select.style.display="none";
        }

        var roll=localStorage.getItem("rollno");
        var rollnum=document.getElementById('rollno').value=roll;

    </script>
</body>
</html>