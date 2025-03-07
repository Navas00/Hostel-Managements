<?php
define("salt",bin2hex(random_bytes(16)));
if(session_status() == PHP_SESSION_ACTIVE){
    //
} else{
    session_start();
}


class User{
    public static function getconn(){
        $ip="127.0.0.1";
        $user="root";
        $pass="";
        $db="myhostel";

        $conn=new mysqli($ip,$user,$pass,$db);
        if($conn->connect_error){
            echo "Error ".$conn->connect_error;
        } else{
            return $conn;
        }
    }

    public static function get_hashed_pass($pass,$salt){
        $pass=hash("sha256",$pass.$salt);
        return strrev($pass);
    }
    public static function set_token($user,$pass,$salt=salt){
        $conn=self::getconn();
        $token=strrev(hash("sha256",$salt.$pass));
        $secure=$conn->prepare("UPDATE user SET token=? WHERE email=?");
        $secure->bind_param("ss",$token,$user);
        $secure->execute();
        setcookie("user",$user);
        setcookie("token",$token,[
            'expires' => time() + 3600,
            'samesite' => 'Strict',
            'httpOnly' => true
        ]);
        return $token;
    }

    public static function filehandle($file){
        $file_is_safe= true;
        $allow=array("jpg"=>"image/jpeg","jpeg"=>"image/jpeg","png"=>"image/png");
        $image=$_FILES["profile"]["tmp_name"];
        $name=$_FILES["profile"]["name"];
        $type= strtolower(pathinfo($name,PATHINFO_EXTENSION));
        $ext=getimagesize($image);
        $mime=$ext['mime'];
        $width=$ext[0];
        $height=$ext[1];


        if($ext === false){
            $file_is_safe = false;
            die("Only jpeg,jpg and png are allowed");
        } elseif(!array_key_exists($type,$allow)){
            $file_is_safe = false;
            die("Only jpeg,jpg and png are allowed");
        } elseif($_FILES["profile"]["size"] > 9999999 ){
            $file_is_safe = false;
            die("File is too large");
        }  elseif(!in_array($mime,$allow)){
            $file_is_safe = false;
            die("Only jpeg,jpg and png are allowed");
        } else{
            if( $file_is_safe != false){
                $image=file_get_contents($image);
                $image=base64_encode($image);
                return $image;
            }
        }

    }

    public function insert_record(){
        $conn=self::getconn();	
        $name=mysqli_real_escape_string($conn,$_POST["name"]);
        $class=mysqli_real_escape_string($conn,$_POST["class"]);
        $rollno=mysqli_real_escape_string($conn,$_POST["rollno"]);
        $fname=mysqli_real_escape_string($conn,$_POST["fname"]);
        $state=mysqli_real_escape_string($conn,$_POST["state"]);
        $zipcode=mysqli_real_escape_string($conn,$_POST["code"]);
        $city=mysqli_real_escape_string($conn,$_POST["city"]);
        $addr=mysqli_real_escape_string($conn,$_POST["addr"]);
        $gender=mysqli_real_escape_string($conn,$_POST["gender"]);
        $phone=mysqli_real_escape_string($conn,$_POST["phone"]);
        $email=mysqli_real_escape_string($conn,$_POST["email"]);
        $pass=mysqli_real_escape_string($conn,$_POST["pass"]);
        $photo=self::filehandle($_FILES["profile"]);
        $hash_pass=self::get_hashed_pass($pass,salt);
        $token=self::set_token($name,$pass);
        $salt=salt;
        $secure=$conn->prepare("INSERT INTO user(name,class,rollno,fname,state,zipcode,city,address,genter,phone,email,salt,password,token,profile) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $secure->bind_param("ssississsisssss",$name,$class,$rollno,$fname,$state,$zipcode,$city,$addr,$gender,$phone,$email,$salt,$hash_pass,$token,$photo);
        $secure->execute();
        $secure->close();
        header("Location: book-hostel.php");

    }

    public function login(){
        $conn=self::getconn();
        $user=mysqli_real_escape_string($conn,trim($_POST["email"]));
        $pass=mysqli_real_escape_string($conn,trim($_POST["pass"]));
        $res=$conn->query("SELECT salt FROM user WHERE email='$user' ");
        $row=$res->fetch_assoc();
        $hash=self::get_hashed_pass($pass,$row['salt']);
        if(isset($_POST['_csrf']) and $_POST['_csrf'] == $_SESSION['csrf_token']){
            //success
        } else{
            header("Location: student_login.php?csrf=1");
        }
        $secure=$conn->prepare("SELECT email,password FROM user WHERE email=? AND password=?");
        $secure->bind_param("ss",$user,$hash);
        if($secure->execute()){
        $result=$secure->get_result();
        $row=$result->fetch_assoc();
        $db_user=empty($row["email"]) ? "null" : $row["email"];
        $db_pass=empty($row["password"]) ? "null" : $row["password"];
        if($db_user == "null" or $db_pass == "null"){
            header("Location: student_login.php?failed=1");
        } else{
            if($db_user == $user and $db_pass == $hash){
                self::set_token($user,$hash,$row['salt']);
                header("Location: dashboard_test.php");
            }
        }
    } else{
        die("query not executed");
    }
}

    public function update(){
        $conn=self::getconn();
        if(isset($_POST['_csrf']) and $_POST['_csrf'] == $_SESSION['csrf_token']){
            //success
        } else{
            header("Location: detail.php?csrf=1");
        }
        $name=mysqli_real_escape_string($conn,$_POST["name"]);
        $class=mysqli_real_escape_string($conn,$_POST["class"]);
        $state=mysqli_real_escape_string($conn,$_POST["state"]);
        $zipcode=mysqli_real_escape_string($conn,$_POST["code"]);
        $city=mysqli_real_escape_string($conn,$_POST["city"]);
        $addr=mysqli_real_escape_string($conn,trim($_POST["addr"]));
        $phone=mysqli_real_escape_string($conn,$_POST["phone"]);
        $email=mysqli_real_escape_string($conn,$_POST["email"]);
        $stmt=$conn->prepare("UPDATE user SET name=?,class=?,state=?,zipcode=?,city=?,address=?,phone=?,email=? WHERE token=?");
        $stmt->bind_param("sssississ",$name,$class,$state,$zipcode,$city,$addr,$phone,$email,$_COOKIE['token']);
        if($stmt->execute()){
            setcookie("user",$email);
            header("Location: detail.php?update=1");
        } else{
            die("record not updated");
        }
    }

    public function upadmin(){
        $conn=self::getconn();
        $atoken=$_COOKIE['token'];
        $res=$conn->query("SELECT * FROM admin");
        $row=$res->fetch_assoc();
        if($atoken != $row['token']){
            die("you are not admin");
        }
        $res->close();
        $rollno=mysqli_real_escape_string($conn,$_POST["rollno"]);
        $name=mysqli_real_escape_string($conn,$_POST["name"]);
        $class=mysqli_real_escape_string($conn,$_POST["class"]);
        $state=mysqli_real_escape_string($conn,$_POST["state"]);
        $zipcode=mysqli_real_escape_string($conn,$_POST["code"]);
        $city=mysqli_real_escape_string($conn,$_POST["city"]);
        $addr=mysqli_real_escape_string($conn,trim($_POST["addr"]));
        $phone=mysqli_real_escape_string($conn,$_POST["phone"]);
        $email=mysqli_real_escape_string($conn,$_POST["email"]);
        $stmt=$conn->prepare("UPDATE user SET name=?,class=?,state=?,zipcode=?,city=?,address=?,phone=?,email=? WHERE rollno=?");
        $stmt->bind_param("sssississ",$name,$class,$state,$zipcode,$city,$addr,$phone,$email,$rollno);
        if($stmt->execute()){
            header("Location: admin_dashboard.php?upstd=true");
        }
    }

    public function book(){
        $conn=self::getconn();
        $roomno=mysqli_real_escape_string($conn,$_POST['roomno']);
        $food=mysqli_real_escape_string($conn,$_POST['food']);
        $fd=empty($_POST['fd']) ? "null" : $_POST['fd'];
        $stayfrom=mysqli_real_escape_string($conn,$_POST['stayfrom']);
        $duration=mysqli_real_escape_string($conn,$_POST['duration']);
        $rollno=mysqli_real_escape_string($conn,$_POST["rollno"]);
        $gname=mysqli_real_escape_string($conn,$_POST["gname"]);
        $rel=mysqli_real_escape_string($conn,$_POST["grelation"]);
        $gnum=mysqli_real_escape_string($conn,$_POST["gnum"]);
        $emerg=mysqli_real_escape_string($conn,$_POST["emergency"]);	
        $setnull="null";
        $stmt=$conn->prepare("INSERT INTO register VALUES(?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("isisisissii",$roomno,$food,$fd,$stayfrom,$duration,$setnull,$rollno,$gname,$rel,$gnum,$emerg);
        if($stmt->execute()){
            $stmt->close();
            $stmt=$conn->prepare("SELECT available,fees,person FROM room WHERE room_id=?");
            $stmt->bind_param("i",$roomno);
            $stmt->execute();
            $res=$stmt->get_result();
            $row=$res->fetch_assoc();
            $available=$row["available"] - 1;
            if($food == "with"){
                $fees=$row['fees'] += ($duration * 9000);
                $final=$fees += ($fd * 2500);
                $user_fees=($duration * 9000) + ($fd * 2500);
            } else{
                $final=$row['fees'] += ($duration * 9000);
                $user_fees=($duration * 9000);
            }
            
            $per=$row['person'] += 1;
            $stmt->close();
            $res=$conn->query("UPDATE register SET fees='$user_fees' ");
            $sql="UPDATE room SET available='$available',fees='$final',person='$per' WHERE room_id='$roomno' ";
            if($conn->query($sql) === TRUE){
                header("Location: dashboard_test.php");
            } else{
                echo "error in room updated";
            }

        }
    }

    public function vacate(){
        $conn=self::getconn();
        if(isset($_POST['_csrf']) and $_POST['_csrf'] == $_SESSION['csrf_token']){
            //success
        } else{
            header("Location: vacate.php?csrf=false");
        }
        $roomno=mysqli_real_escape_string($conn,$_POST['roomno']);
        $reason=mysqli_real_escape_string($conn,$_POST['reason']);
        $token=$_COOKIE['token'];
        $status="pending";
        $stmt=$conn->prepare("INSERT INTO vacate(room_no,reason,status,token) VALUES(?,?,?,?)");
        $stmt->bind_param("isss",$roomno,$reason,$status,$token);
        $stmt->execute();
        header("Location: vacate.php?submit=1");
    }

    public function logout(){
        $conn=self::getconn();
        $token=mysqli_real_escape_string($conn,$_COOKIE['token']);
        $user=mysqli_real_escape_string($conn,$_COOKIE['user']);
        $conn->query("UPDATE user SET token='' WHERE token='$token' AND email='$user'");
        setcookie("user","",time() - 3600);
        setcookie("token","",time() - 3600);
    }

    public function changepass(){
        $conn=self::getconn();
        $token=$_COOKIE['token'];
        if(isset($_POST['_csrf']) and $_POST['_csrf'] == $_SESSION['csrf_token']){
            //success
        } else{
            header("Location: change-password.php?csrf=1");
        }
        $res=$conn->query("SELECT salt FROM user WHERE token='$token'");
        $row=$res->fetch_assoc();
        $cpass=mysqli_real_escape_string($conn,$_POST["cpass"]);
        $hcpass=self::get_hashed_pass($cpass,$row['salt']);
        $npass=mysqli_real_escape_string($conn,$_POST["npass"]);
        $hnpass=self::get_hashed_pass($npass,salt);
        $stmt=$conn->prepare("SELECT password,token FROM user WHERE token=?");
        $stmt->bind_param("s",$token);
        $stmt->execute();
        $res=$stmt->get_result();
        $row=$res->fetch_assoc();
        $stmt->close();
        $curvalid=false;
        $token=empty($row['token']) ? "null" : $row['token'];
        if($token != "null"){
            if($row['password'] == $hcpass){
                $curvalid=true;
            }
        } else{
            $curvalid=false;
            die("token or password incorrect");
        }
        if($curvalid == true){
            $stmt=$conn->prepare("UPDATE user SET password=?,salt=? WHERE token=? AND email=?");
            $csalt=salt;
            $stmt->bind_param("ssss",$hnpass,$csalt,$token,$_COOKIE['user']);
            $stmt->execute();
            self::set_token($_COOKIE['user'],$hnpass);
            header("Location: dashboard_test.php");
        } else{
            header('Location: change-password.php?old=1');
        }



    }
}


if(isset($_POST["register"])){
    $obj=new User();
    $obj->insert_record();
} elseif(isset($_POST["login"])){
    $obj=new User();
    $obj->login();
} elseif(isset($_POST['update'])){
    $obj=new User();
    $obj->update();
} elseif(isset($_POST['chpass'])){
    $obj=new User();
    $obj->changepass();
} elseif(isset($_POST['book'])){
    $obj=new User();
    $obj->book();
} elseif(isset($_POST['vacate'])){
    $obj=new User();
    $obj->vacate();
} elseif(isset($_POST['logout'])){
    $obj=new User();
    $obj->logout();
} elseif(isset($_POST['ad_update'])){
    $obj=new User();
    $obj->upadmin();
} else{
    //
}


?>