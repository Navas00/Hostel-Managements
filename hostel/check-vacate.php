<?php
require_once "db.php";

class Check extends Admindb{
    public function check(){
        $conn=parent::getconn();
        $res=$conn->query("SELECT * FROM vacate WHERE status='pending' ");
        $gst=$conn->query("SELECT * FROM guest");
        $total=$res->num_rows + $gst->num_rows;
        if($res->num_rows > 0 or $gst->num_rows > 0){
            echo $total;
        }
    }

    public function data(){
        $conn=parent::getconn();
        $res=$conn->query("SELECT * FROM vacate WHERE status='pending' ");
        if($res->num_rows >0){
                $row=$res->fetch_assoc();
                $vacate=$row['room_no'];
                $detail=$conn->query("SELECT user.name,user.rollno,user.token,vacate.token,vacate.status FROM user,vacate WHERE vacate.token=user.token AND vacate.status='pending'");
                while($user=$detail->fetch_assoc()){
                    echo "<div id=\"vperson\" class=\"col\">
        <ul class=\"list-group\">
            <li class=\"list-group-item text-center fs-3\">
                <div class=\"row\">
                    <div class=\"col-md-6\">
                        <h3>".$user["name"]."</h3>
                        <h5>Request For Vacate Room</h5>
                    </div>
                    <div class=\"col-md-6\">
                        <div class=\"d-grid d-md-flex mt-2 justify-content-md-end\">
                            <button class=\"btn btn-primary mb-3\" onclick=\"showdetail(this.value)\" value=\"".$user['token']."\">view</button>
                       </div>
                    </div>
                </div>
                </div>";
                }
            }
        }
    
    public function getguest(){
        $conn=parent::getconn();
        $res=$conn->query("SELECT * FROM guest");
        if($res->num_rows > 0){
            while($row=$res->fetch_assoc()){
                
            }
        }
    }

    public function getreason(){
        $conn = parent::getconn();
        $token=mysqli_real_escape_string($conn,$_POST['token']);
        $sql="SELECT user.name,user.rollno,register.room_no,user.token FROM user INNER JOIN register ON user.token='$token' AND user.rollno=register.rollno";
        $sql2="SELECT room_no AS vroom,reason FROM vacate WHERE token='$token' AND status='pending' ";
        $res=$conn->query($sql);
        $res2=$conn->query($sql2);
        while($row=$res->fetch_assoc() and $vac=$res2->fetch_assoc()){
            $rm=$vac['vroom'];
            $avai=$conn->query("SELECT available FROM room WHERE room_id='$rm'");
            $av=$avai->fetch_assoc();
            echo "<div class=\"card\" id=\"".$row['rollno']."\">
            <div class=\"card-body\">
                <h5 class=\"text-center\">Vacate Request</h5>
                <div class=\"row my-3\">
                    <div class=\"col\"><h5>Name:</h5></div>
                    <div class=\"col\">".$row['name']."</div>
                </div>
                <div class=\"row my-3\">
                    <div class=\"col\"><h5>Roll No:</h5></div>
                    <div class=\"col\">".$row['rollno']."</div>
                </div>
                <div class=\"row my-3\">
                    <div class=\"col\"><h5>Room No:</h5></div>
                    <div class=\"col\">".$row['room_no']."</div>
                    <div class=\"col\"><h5>Available Vacate Room:</h5></div>
                    <div class=\"col\">".$av['available']."</div>
                </div>
                <div class=\"row my-3\">
                    <div class=\"col\"><h5>Room To Vacate:</h5></div>
                    <div class=\"col\">".$vac['vroom']."</div>
                </div>
                <div class=\"row my-3\">
                    <h5>Reason:</h5>
                    <p style=\"font-size: 18px; text-align: center;\">".$vac['reason']."</p>
                </div>
                <div class=\"d-grid d-md-flex justify-content-md-around\">
                    <button onclick=\"accept()\" style=\"background-color:#5dcb65; color: white;\" class=\"btn\">Accept</button>
                    <input id=\"token\" type=\"hidden\" name=\"tok\" value=\"".$row['token']."\">
                    <button onclick=\"reject()\" class=\"btn btn-danger\">Reject</button>
                </div>
            </div>
        </div>";
        break;
        }
    }

    public function status(){
        $conn=parent::getconn();
        $st=mysqli_real_escape_string($conn,$_POST['status']);
        $t=mysqli_real_escape_string($conn,$_POST['tok']);
        if($st == "accept"){
            $conn->query("UPDATE vacate SET status='accept' WHERE token='$t' ");
            echo "<div class=\"alert alert-success alert-dismissible fade show\">
                            <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                            <h4 class=\"text-center\">Your Desicion is Submitted!</h4>
                            <h6 class=\"text-center\">Thank You!</h6>
                            </div>";
        } elseif($st == "reject"){
            $conn->query("UPDATE vacate SET status='reject' WHERE token='$t' ");
            echo "<div class=\"alert alert-success alert-dismissible fade show\">
                            <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                            <h4 class=\"text-center\">Your Desicion is Submitted!</h4>
                            <h6 class=\"text-center\">Thank You!</h6>
                            </div>";
        }
    }

    public function getnum(){
        $conn=parent::getconn();
        $tok=mysqli_real_escape_string($conn,$_COOKIE['token']);
        $res=$conn->query("SELECT * FROM vacate WHERE token='$tok' AND status !='pending'");
        if($res->num_rows > 0){
            echo $res->num_rows;
        }
    }

    public function showres(){
        $conn=parent::getconn();
        $tok=mysqli_real_escape_string($conn,$_COOKIE['token']);
        $res=$conn->query("SELECT * FROM vacate WHERE token='$tok' AND status !='pending'");
        $row=$res->fetch_assoc();
        $status=empty($row['status']) ? "null" : $row['status'];
        if($status != "null"){
            if($row['status'] == "accept"){
                echo "<div class=\"alert alert-success alert-dismissible fade show\">
                <h4 class=\"text-center\">Your Vacate Room Request Is Accept</h4>
                <h6 class=\"text-center\">Please Contact Hostel Manager</h6>
            </div>";
            } elseif($row['status'] == "reject"){
                echo "<div class=\"alert alert-danger alert-dismissible fade show\">
                <h4 class=\"text-center\">Your Vacate Room Request Is Accept</h4>
                <h6 class=\"text-center\">Please Contact Hostel Manager</h6>
            </div>";
            } elseif($row['status'] == "pending"){
                echo "<div class=\"alert alert-info alert-dismissible fade show\">
                <h4 class=\"text-center\">Your Vacate Room Request Is Pending</h4>
            </div>";
            }
        } 
    }
}

$check=new Check();

if(isset($_GET['data'])){
    $check->data();
} elseif(isset($_GET['getmsg'])){
    $check->check();
} elseif(isset($_POST['view'])){
    $check->getreason();
} elseif(isset($_POST['status'])){
    $check->status();
} elseif(isset($_POST['chksts'])){
    $check->getnum();
} elseif(isset($_POST['chkinb'])){
    $check->showres();
} else{
    //
}

?>