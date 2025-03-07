<?php

require_once "user.php";

if(session_status() == PHP_SESSION_ACTIVE){
    //active
} else{
    session_start();
}

if(!isset($_SESSION['csrf_token'])){
    $_SESSION['csrf_token']=bin2hex(random_bytes(32));
}

class Profile extends User{
    public function check_token(){
        $conn=parent::getconn();
        if(isset($_COOKIE["user"]) and isset($_COOKIE["token"])){
            $c_user=$_COOKIE["user"];
            $c_token=$_COOKIE["token"];
            $secure=$conn->prepare("SELECT * FROM user WHERE email=? AND token=?");
            $secure->bind_param("ss",$c_user,$c_token);
            $secure->execute();
            $result=$secure->get_result();
            global $res;
            $res=$result->fetch_assoc();
            if($res["email"] == $c_user and $res["token"] == $c_token){
                global $isupdate;
                $isupdate=true;
            } else{
                header("Location: student_login.html");
            }

        }
    }
}

$obj=new Profile();
$obj->check_token();



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details</title>
    <link rel="stylesheet" href="bootstrap-5.3.0-alpha1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="detail.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card mt-5">
                    <form action="user.php" method="post">
                        <div class="card-body">
                            <?php 
                            if(isset($_GET['update']) and $isupdate == true ){
                                echo "<div class=\"alert alert-success alert-dismissible fade show\">
                                      <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                                      <h4 class=\"text-center\">Your Profile Is Updated</h4>
                                      </div>";
                                }
                                if(isset($_GET['csrf'])){
                                    echo "<div class=\"alert alert-danger alert-dismissible fade show\">
                                          <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                                          <h4 class=\"text-center\">Invalid CSRF Token</h4>
                                          </div>";
                                    }
                            ?>
                            <div class="profil d-flex">
                                <img src="data:image;base64,<?php echo $res["profile"];?>" style="height: 150px; width: 150px;border-radius: 50%;" alt="profile" class="mx-auto card-img-top">
                            </div>
                            <p class="form-label text-primary">Personal Details</p>
                            <div class="mb-3">
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="name" class="form-label">Full Name</label>
                                            <input type="text" name="name" value="<?php echo $res["name"]; ?>" placeholder="Enter full name" class="form-control text-muted">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" id="email" value="<?php echo $res["email"]; ?>" class="form-control text-muted" name="email" placeholder="Enter email ID">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="number" id="phone" value="<?php echo $res["phone"]; ?>" placeholder="Enter phone number" name="phone" class="text-muted form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="city" class="form-label">Class</label>
                                        <input type="text" class="text-muted form-control" value="<?php echo $res["class"]; ?>" placeholder="Enter your class" name="class" id="city">
                                    </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <p class="form-label text-primary">Address</p>
                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="state" class="form-label">State</label>
                                                <input type="text" value="<?php echo $res["state"]; ?>" id="state" placeholder="Enter your state" name="state" class="form-control text-muted">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="zip" class="form-label">Zip Code</label>
                                                <input type="text" id="zip" value="<?php echo $res["zipcode"]; ?>" placeholder="Enter your zip code" name="code" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="city" class="form-label">City</label>
                                                <input type="text" id="city" value="<?php echo $res["city"]; ?>" placeholder="Enter your city" name="city" class="form-control text-muted">
                                                <input type="hidden" name="_csrf" value="<?php echo $_SESSION['csrf_token']; ?>">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="addr" class="form-label">Address</label>
                                                <textarea style="resize: none; white-space: pre-line;" name="addr" id="addr" placeholder="Enter your address" class="form-control"><?php echo trim($res["address"]); ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="d-grid">
                                                <button class="btn btn-primary mx-auto w-50" name="update">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script src="bootstrap-5.3.0-alpha1-dist/js/bootstrap.min.js"></script>
</body>
</html>