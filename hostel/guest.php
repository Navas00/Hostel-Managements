<?php

function conn(){

    $host="127.0.0.1";
    $user="root";
    $pass="root";
    $db="myhostel";
    if($conn=mysqli_connect($host,$user,$pass,$db)){
        return $conn;
    } else{
        echo "error ".mysqli_connect_error();
    }
}

function touched($email){
    $conn=conn();
    $res=$conn->query("SELECT email FROM guest");
    while($row=$res->fetch_array()){
        if($email == $row['email']){
            die("already exit");
        }
    }

}

function guestmsg(){
    $conn=conn();
    $name=mysqli_real_escape_string($conn,$_POST['name']);
    $email=mysqli_real_escape_string($conn,$_POST['email']);
    $msg=mysqli_real_escape_string($conn,$_POST['msg']);
    touched($email);
    $res=$conn->prepare("INSERT INTO guest VALUES(?,?,?)");
    $res->bind_param("sss",$name,$email,$msg);
    if($res->execute()){
        header("Location: index.html?touch=true#contact");
    }
}

function getmsg(){
    $conn=conn();
    $res=$conn->query("SELECT * FROM guest");
    if($res->num_rows > 0){
        while($row=$res->fetch_assoc()){
            echo "<div class=\"col-md-8 mx-auto\">
            <div class=\"card\">
                <div class=\"card-body\">
                    <div class=\"mb-3\">
                        <div class=\"row\">
                            <div class=\"col\">
                                <h5>Name:</h5>
                            </div>
                            <div class=\"col\">
                                <p>".$row['name']."</p>
                            </div>
                        </div>
                    </div>
                    <div class=\"mb-3\">
                        <div class=\"row\">
                            <div class=\"col\">
                                <h5>Email:</h5>
                            </div>
                            <div class=\"col\">
                                <p>".$row['email']."</p>
                            </div>
                        </div>
                    </div>
                    <div class=\"mb-3\">
                        <h5>Message:</h5>
                        <p>".$row['message']."</p>
                    </div>
                </div>
            </div>
          </div>";
        }
    }
}

if(isset($_POST['touch'])){
    guestmsg();
}
if(isset($_GET['data'])){
    getmsg();
}

?>