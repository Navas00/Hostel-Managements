<?php

define("salt",bin2hex(random_bytes(16)));

if(session_status() == PHP_SESSION_ACTIVE){
    //active
} else{
    session_start();
}

class Admindb{
    public static function getconn(){
        $ip="127.0.0.1";
        $user="root";
        $pass="";
        $db="myhostel";

        $conn= new mysqli($ip,$user,$pass,$db);
        if($conn->connect_error){
            echo "connection error ".$conn->connect_error;
        } else{
            return $conn;
        }
    }

    public function do_login($user,$pass){
        $conn= self::getconn();
        if(isset($_POST['_csrf']) and $_POST['_csrf'] == $_SESSION['csrf_token']){
            //success
        } else{
            header("Location: glass_login.php?csrf=1");
        }
        $res=$conn->query("SELECT salt FROM admin WHERE username='$user'");
        $row=$res->fetch_assoc();
        $hash=self::get_hashed_pass($pass,$row['salt']);
        $sql="SELECT username,password FROM admin WHERE username='$user' AND password='$hash'";
        $res=$conn->query($sql);
        if($res->num_rows == 01 ){
            $token=self::setcook($user,$hash);
            $set_valid="update admin set is_valid=1 where username='$user';";
            $set_valid .="update admin set token='$hash' where username='$user';";
            if($conn->multi_query($set_valid)){
            header("Location: admin_dashboard.php");
            }
            
        } else{
            header("Location: glass_login.php?error=1");
        }
    }

    public function addroom(){
        $conn=self::getconn();
        $seater=mysqli_real_escape_string($conn,$_POST['seatno']);
        $room_no=mysqli_real_escape_string($conn,$_POST['room_id']);
        $stmt=$conn->prepare("INSERT INTO room(person,available,room_id) VALUES(?,?,?)");
        $person=0;
        $stmt->bind_param("iis",$person,$seater,$room_no);
        echo "seater no ==>".$seater;
        echo "room ==>".$room_no;
        if($stmt->execute()){
            header("Location: add-room.php?success=1");
        } else{
            header("Location: add-room.php?failed=1");
        }
    }

    public function getroom(){
        $conn=self::getconn();
        $stmt=$conn->query("SELECT * FROM room");
        static $sno=1;
        echo "
        <div class=\"card\">
        <div class=\"card-body\">
        <table class=\"table table-responsive table-striped\">
        <thead>
            <th>S.No</th>
            <th>Seater</th>
            <th>Available</th>
            <th>Room No</th>
            <th>Fees</th>
            <th>Action</th>
        </thead>
        <tbody> ";
        while($res=$stmt->fetch_assoc()){
            echo "<tr>
            <td>".$sno."</td>
            <td>".$res['person']."</td>
            <td>".$res['available']."</td>
            <td>".$res['room_id']."</td>
            <td>".$res['fees']."</td>
            <td><div class=\"d-flex justify-content-around align-item-center\">
                <button style=\"border: none\" class=\"text-info\" title=\"Delete\" onclick=\"deleterow(this.value)\" value=\"".$res['room_id']."\"><i class=\"fas text-danger fa-times\"></i></button>
                <button class=\"text-info\" style=\"border: none\" title=\"Edit\" onclick=\"editerow(this.value)\" value=\"".$res['room_id']."\"><i class=\"fas fa-edit\"></i></button>
            </div></td>
            </tr>";
            $sno++;
        }
        echo "</tbody>
        </table>
        </div>
        </div>
        ";

    }

    public static function get_student(){
        $conn=self::getconn();
        $query=$conn->query("SELECT room_id FROM room");
        while($row=$query->fetch_assoc()){
            $room=$row['room_id'];
            $details=$conn->query("SELECT user.name,user.rollno,user.phone,register.rollno,register.stay_from,register.room_no FROM user,register WHERE user.rollno=register.rollno AND register.room_no ='$room'");
            echo "<h5 class=\"mt-3\">Room No: ".$room."</h5>";
            if($details->num_rows > 0){
                echo "<div class=\"col mx-auto mx-3\">
                <div class=\"card\">
                    <div class=\"card-body\">
                    <table class=\"table table-striped table-responsive\">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Name</th>
                                        <th>Roll No</th>
                                        <th>Phone Number</th>
                                        <th>Staying From</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>";
                while($dt_row=$details->fetch_assoc()){
                    static $sno=1;
                    echo "<tbody>
                    <tr>
                        <td>".$sno."</td>
                        <td>".$dt_row['name']."</td>
                        <td>".$dt_row['rollno']."</td>
                        <td>".$dt_row['phone']."</td>
                        <td>".$dt_row['stay_from']."</td>
                        <td><div class=\"d-flex justify-content-around align-item-center\">
                <button style=\"border: none\" class=\"text-info\" title=\"Delete\" onclick=\"dstudent(this.value)\" value=\"".$dt_row['rollno']."\"><i class=\"fas text-danger fa-times\"></i></button>
                <button class=\"text-info\" style=\"border: none\" title=\"Edit\" onclick=\"editstudent(this.value)\" value=\"".$dt_row['rollno']."\"><i class=\"fas fa-edit\"></i></button></div></td>
                    </tr>";
                    $sno++;
                }
                echo "</tbody>
                    </table>
                    </div>
                    </div>";
                    $sno=1;
            } else{
                echo "<div class=\"col mb-3 mx-auto mx-3\">
                <div class=\"card\">
                    <div class=\"card-body\">
                    <h5>The Room Is Free</h5>
                    </div>
                    </div>";
            }
        }
    }

    public function estudent(){
        $conn=self::getconn();
        $rollno=mysqli_real_escape_string($conn,$_POST['rollno']);
        $secure=$conn->prepare("SELECT * FROM user WHERE rollno=?");
        $secure->bind_param("i",$rollno);
        $secure->execute();
        $result=$secure->get_result();
        $res=$result->fetch_assoc();
        echo "<div class=\"col-md-8 mx-auto\">
        <div class=\"card mt-5\">
            <form action=\"user.php\" method=\"post\">
                <div class=\"card-body\">
                    <div class=\"profil d-flex\">
                        <img src=\"data:image;base64,".$res["profile"]."\" style=\"height: 150px; width: 150px;border-radius: 50%;\" alt=\"profile\" class=\"mx-auto card-img-top\">
                    </div>
                    <p class=\"form-label text-primary\">Personal Details</p>
                    <div class=\"mb-3\">
                        <div class=\"mb-3\">
                            <div class=\"row\">
                                <div class=\"col-md-6 mb-3\">
                                    <label for=\"name\" class=\"form-label\">Full Name</label>
                                    <input type=\"text\" name=\"name\" value=\"".$res["name"]."\" placeholder=\"Enter full name\" class=\"form-control text-muted\">
                                </div>
                                <div class=\"col-md-6\">
                                    <label for=\"email\" class=\"form-label\">Email</label>
                                    <input type=\"email\" id=\"email\" value=\"".$res["email"]."\" class=\"form-control text-muted\" name=\"email\" placeholder=\"Enter email ID\">
                                </div>
                            </div>
                        </div>
                        <div class=\"mb-3\">
                            <div class=\"row\">
                            <div class=\"col-md-6 mb-3\">
                                <label for=\"phone\" class=\"form-label\">Phone</label>
                                <input type=\"number\" id=\"phone\" value=\"".$res["phone"]."\" placeholder=\"Enter phone number\" name=\"phone\" class=\"text-muted form-control\">
                            </div>
                            <div class=\"col-md-6\">
                                <label for=\"city\" class=\"form-label\">Class</label>
                                <input type=\"text\" class=\"text-muted form-control\" value=\"".$res["class"]."\" placeholder=\"Enter your class\" name=\"class\" id=\"city\">
                            </div>
                            </div>
                        </div>
                        <div class=\"mb-3\">
                            <p class=\"form-label text-primary\">Address</p>
                            <div class=\"mb-3\">
                                <div class=\"row\">
                                    <div class=\"col-md-6 mb-3\">
                                        <label for=\"state\" class=\"form-label\">State</label>
                                        <input type=\"text\" value=\"".$res["state"]."\" id=\"state\" placeholder=\"Enter your state\" name=\"state\" class=\"form-control text-muted\">
                                    </div>
                                    <div class=\"col-md-6\">
                                        <label for=\"zip\" class=\"form-label\">Zip Code</label>
                                        <input type=\"text\" id=\"zip\" value=\"".$res["zipcode"]."\" placeholder=\"Enter your zip code\" name=\"code\" class=\"form-control\">
                                    </div>
                                </div>
                            </div>
                            <div class=\"mb-3\">
                                <div class=\"row\">
                                    <div class=\"col-md-6 mb-3\">
                                        <label for=\"city\" class=\"form-label\">City</label>
                                        <input type=\"text\" id=\"city\" value=\"".$res["city"]."\" placeholder=\"Enter your city\" name=\"city\" class=\"form-control text-muted\">
                                    </div>
                                    <div class=\"col-md-6\">
                                        <label for=\"addr\" class=\"form-label\">Address</label>
                                        <textarea style=\"resize: none; white-space: pre-line;\" name=\"addr\" id=\"addr\" placeholder=\"Enter your address\" class=\"form-control\">".trim($res["address"])."</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class=\"mb-3\">
                                <div class=\"d-grid\">
                                        <input type=\"hidden\" name=\"rollno\" value=\"".$rollno."\">
                                        <button class=\"btn btn-primary mx-auto w-50\" name=\"ad_update\">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>";
    }

    public function roomd(){
        $conn=self::getconn();
        $room=mysqli_real_escape_string($conn,$_POST['room_no']);
        $stmt=$conn->prepare("SELECT * FROM room WHERE room_id=?");
        $stmt->bind_param("s",$room);
        if($stmt->execute()){
            $res=$stmt->get_result();
            $row=$res->fetch_assoc();
            echo "<div class=\"row\">
            <div class=\"col-md-8 mx-auto\">
            <form method=\"POST\" action=\"db.php\">
              <div class=\"card\">
                <div class=\"card-body\">
                      <div class=\"mb-3\">
                        <label for=\"seat\" class=\"form-label\">Seater</label>
                        <input type=\"number\" name=\"person\" value=\"".$row['person']."\" id=\"seat\" class=\"form-control\">
                      </div>
                      <div class=\"mb-3\">
                        <label for=\"rn\" class=\"form-label\">Room No <span class=\"text-muted\">(can't Be Changed)</span></label>
                        <input type=\"number\" id=\"rn\" name=\"roomno\" value=\"".$row['room_id']."\" class=\"form-control\" readonly>
                      </div>
                      <div class=\"mb-4\">
                        <label for=\"fees\" class=\"form-label\">Fees</label>
                        <input type=\"number\" id=\"fees\" value=\"".$row['fees']."\" name=\"fees\" class=\"form-control\">
                      </div>
                      <div class=\"d-flex align-item-center justify-content-center\">
                      <button class=\"btn btn-primary w-50\" name=\"updroom\">submit</button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>";
        }

    }

    public function updateroom(){
        $conn=self::getconn();
        $seater=mysqli_real_escape_string($conn,$_POST['person']);
        $room=mysqli_real_escape_string($conn,$_POST['roomno']);
        $fees=mysqli_real_escape_string($conn,$_POST['fees']);
        $res=$conn->query("SELECT person FROM room WHERE room_id='$room'");
        $row=$res->fetch_assoc();
        $available=max(($seater - $row['person']),0);
        $conn->query("UPDATE room SET person='$seater',fees='$fees',available='$available' WHERE room_id='$room'");
        header("Location: admin_dashboard.php?update=1");
       

    }

    public function deletetable(){
        $conn = self::getconn();
        $room=mysqli_real_escape_string($conn,$_POST['room_id']);
        $stmt=$conn->prepare("DELETE FROM room WHERE room_id = ? ");
        $stmt->bind_param("s",$room);
        $stmt->execute();
    }

    public function delete_student(){
        $conn = self::getconn();
        $room=mysqli_real_escape_string($conn,$_POST['roll_no']);
        $sql="DELETE FROM user WHERE rollno='$room';";
        $sql .= "DELETE FROM register WHERE rollno='$room'";
        $conn->multi_query($sql);

    }

    public function deletestaff(){
        $conn = self::getconn();
        $phone=mysqli_real_escape_string($conn,$_POST['phoneno']);
        $stmt=$conn->prepare("DELETE FROM staff WHERE phone=?");
        $stmt->bind_param("i",$phone);
        if($stmt->execute()){
            header("Location: admin_dashboard.php?ds=true");
        }
    }

    public function regstaff(){
        echo "<div class=\"col-6 mx-auto\">
        <div class=\"card\">
        <div class=\"card-body\">
          <form action=\"db.php\" method=\"post\">
            <div class=\"mb-3\">
              <label for=\"name\" class=\"form-label\">Name</label>
              <input type=\"text\" placeholder=\"Name\" class=\"form-control\" name=\"name\" id=\"name\">
            </div>
            <div class=\"mb-3\">
              <label for=\"email\" class=\"form-label\">Email</label>
              <input type=\"email\" name=\"email\" placeholder=\"example@gmail.com\" class=\"form-control\" required>
            </div>
            <div class=\"mb-3\">
              <label for=\"pno\" class=\"form-label\">Phone Number</label>
              <input type=\"number\" name=\"pno\" id=\"pno\" placeholder=\"+91 94567 89062\" class=\"form-control\" required>
            </div>
            <div class=\"mb-3\">
              <label for=\"pose\" class=\"form-label\">Position</label>
              <input type=\"text\" name=\"position\" id=\"pose\" placeholder=\"Position\" class=\"form-control\" required>
            </div>
            <div class=\"mb-3\">
              <label for=\"salary\" class=\"form-label\">Salary</label>
              <input type=\"number\" name=\"salary\" id=\"salary\" placeholder=\"Salary\" class=\"form-control\" required>
            </div>
            <div class=\"d-grid\">
              <button name=\"addstaff\" class=\"btn btn-primary\">Submit</button>
            </div>
          </form>
        </div>
      </div>
        </div>";
    }

    public function addstaff(){
        $conn=self::getconn();
        $name=mysqli_real_escape_string($conn,$_POST['name']);
        $email=mysqli_real_escape_string($conn,$_POST['email']);
        $pno=mysqli_real_escape_string($conn,$_POST['pno']);
        $position=mysqli_real_escape_string($conn,$_POST['position']);
        $salary=mysqli_real_escape_string($conn,$_POST['salary']);
        $stmt=$conn->prepare("INSERT INTO staff(name,email,phone,position,salary) VALUES(?,?,?,?,?)");
        $stmt->bind_param("ssisi",$name,$email,$pno,$position,$salary);
        if($stmt->execute()){
            header('Location: admin_dashboard.php?addstaff=true');
        } else{
            header('Location: admin_dashboard.php?addstaff=false');
        }
        
    }

    public function showstaff(){
      $conn=self::getconn();
      $sql="SELECT * FROM staff";
      $res=$conn->query($sql);
      echo "<div class=\"col mx-auto bg-white mt-5\">
        <table class=\"table table-striped table-hover\">
          <thead>
            <tr>
              <th>S.No</th>
              <th>Name</th>
              <th>Email</th>
              <th>Phone Number</th>
              <th>Position</th>
              <th>Hire Date</th>
              <th>Salary</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>";
      while($row=$res->fetch_assoc()){
        static $sno=1;
        echo "<tr>
        <td>".$sno."</td>
        <td>".$row['name']."</td>
        <td>".$row['email']."</td>
        <td>".$row['phone']."</td>
        <td>".$row['position']."</td>
        <td>".$row['hire_date']."</td>
        <td>".$row['salary']."</td>
        <td><div class=\"d-flex justify-content-around align-item-center\">
                <button style=\"border: none\" class=\"text-info\" title=\"Delete\" onclick=\"deletestaff(this.value)\" value=\"".$row['phone']."\"><i class=\"fas text-danger fa-times\"></i></button>
                <button class=\"text-info\" style=\"border: none\" title=\"Edit\" onclick=\"upstaff(this.value)\" value=\"".$row['phone']."\"><i class=\"fas fa-edit\"></i></button>
            </div></td>
      </tr>";
      $sno++;
      }
      echo "</tbody>
      </table>
      </div>";
    }

    public function updatestaff(){
        $conn=self::getconn();
        $name=mysqli_real_escape_string($conn,$_POST['name']);
        $email=mysqli_real_escape_string($conn,$_POST['email']);
        $pno=mysqli_real_escape_string($conn,$_POST['pno']);
        $position=mysqli_real_escape_string($conn,$_POST['position']);
        $salary=mysqli_real_escape_string($conn,$_POST['salary']);
        $stmt=$conn->prepare("UPDATE staff SET name=?,email=?,phone=?,position=?,salary=? WHERE phone=?");
        $stmt->bind_param("ssisii",$name,$email,$pno,$position,$salary,$pno);
        if($stmt->execute()){
           header('Location: admin_dashboard.php?ups=true');
        }
    }

    public function editstaff(){
        $conn=self::getconn();
        $phone=mysqli_real_escape_string($conn,$_POST['phoneno']);
        $stmt=$conn->prepare("SELECT * FROM staff where phone=?");
        $stmt->bind_param("i",$phone);
        $stmt->execute();
        $res=$stmt->get_result();
        while($row=$res->fetch_assoc()){
            echo "<div class=\"col-6 mx-auto\">
            <div class=\"card\">
            <div class=\"card-body\">
              <form action=\"db.php\" method=\"post\">
                <div class=\"mb-3\">
                  <label for=\"name\" class=\"form-label\">Name</label>
                  <input type=\"text\" placeholder=\"Name\" class=\"form-control\" name=\"name\" value=\"".$row['name']."\" id=\"name\">
                </div>
                <div class=\"mb-3\">
                  <label for=\"email\" class=\"form-label\">Email</label>
                  <input type=\"email\" name=\"email\" value=\"".$row['email']."\" placeholder=\"example@gmail.com\" class=\"form-control\" required>
                </div>
                <div class=\"mb-3\">
                  <label for=\"pno\" class=\"form-label\">Phone Number</label>
                  <input type=\"number\" name=\"pno\" value=\"".$row['phone']."\" id=\"pno\" placeholder=\"+91 94567 89062\" class=\"form-control\" required>
                </div>
                <div class=\"mb-3\">
                  <label for=\"pose\" class=\"form-label\">Position</label>
                  <input type=\"text\" name=\"position\" value=\"".$row['position']."\" id=\"pose\" placeholder=\"Position\" class=\"form-control\" required>
                </div>
                <div class=\"mb-3\">
                  <label for=\"salary\" class=\"form-label\">Salary</label>
                  <input type=\"number\" name=\"salary\" value=\"".$row['salary']."\" id=\"salary\" placeholder=\"Salary\" class=\"form-control\" required>
                </div>
                <div class=\"d-grid\">
                  <button name=\"updatestaff\" class=\"btn btn-primary\">Update</button>
                </div>
              </form>
            </div>
          </div>
            </div>";
        }
    }


    public static function get_hashed_pass($pass,$salt=salt){
            return strrev(hash("sha256",$pass.$salt));
        }

    public static function setcook($user,$pass){
            setcookie("username",$user,[
                'httpOnly' => true
            ]);
            setcookie("token",$pass,[
                'httpOnly' => true,
                'samesite' => 'Strict'
            ]);
        }
    
    public function logout(){
        $conn=self::getconn();
        $conn->query("UPDATE admin SET is_valid=0 WHERE username='admin' ");
        setcookie("username","");
        setcookie("token","");
    }
}

if(isset($_POST["submit"])){
    $ob=new Admindb();
    $ob->do_login($_POST["username"],$_POST["pass"]);

} elseif(isset($_POST['addroom'])){
    $ob=new Admindb();
    $ob->addroom();
} elseif(isset($_POST['getroom'])){
    $ob=new Admindb();
    $ob->getroom();
} elseif(isset($_POST['deletetable'])){
    $ob=new Admindb();
    $ob->deletetable();
} elseif(isset($_POST['logout'])){
    $ob=new Admindb();
    $ob->logout();
} elseif(isset($_POST['roomd'])){
    $ob=new Admindb();
    $ob->roomd();
} elseif(isset($_POST['updroom'])){
    $ob=new Admindb();
    $ob->updateroom();
} elseif(isset($_POST['getstudent'])){
    $ob=new Admindb();
    $ob->get_student();
} elseif(isset($_POST['dstudent'])){
    $ob=new Admindb();
    $ob->delete_student();
} elseif(isset($_POST['regstaff'])){
    $ob=new Admindb();
    $ob->regstaff();
} elseif(isset($_POST['addstaff'])){
    $ob=new Admindb();
    $ob->addstaff();
} elseif(isset($_POST['mgstaff'])){
    $ob=new Admindb();
    $ob->showstaff();
} elseif(isset($_POST['deletestaff'])){
    $ob=new Admindb();
    $ob->deletestaff();
} elseif(isset($_POST['upstaff'])){
    $ob=new Admindb();
    $ob->editstaff();
} elseif(isset($_POST['updatestaff'])){
    $ob=new Admindb();
    $ob->updatestaff();
} elseif(isset($_POST['estudent'])){
    $ob=new Admindb();
    $ob->estudent();
} else{
    //
}

?>