<?php

include "db.php";

if(session_status() == PHP_SESSION_ACTIVE){
    //
} else{
    session_start();
}

if(!isset($_SESSION['csrf_token'])){
    $_SESSION['csrf_token']=bin2hex(random_bytes(32));
}

class Redirect extends Admindb{
    public static function ispostauth(){
        $conn=parent::getconn();
        $client_token=$_COOKIE["token"];
        $sql="SELECT token FROM admin WHERE username='admin' AND is_valid=1";
        $result=$conn->query($sql);
        while($row=$result->fetch_assoc()){
            if($row["token"] == $client_token){
            header("Location: admin_dashboard.php");
        }
    }
    }
}

if(isset($_COOKIE["token"])){
    Redirect::ispostauth();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="bootstrap-5.3.0-alpha1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="glass.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://www.google.com/recaptcha/api.js"></script>

</head>
<body>
    <div class="bg-hero">
       <div class="container">
        <div class="row">
            <div class="col-md-5 mx-auto">
                <div class="card mt-5 p-4 text-dark">
                    <div class="card-body">
                    <?php if(isset($_GET['error'])){
                        echo "<div class=\"alert alert-danger alert-dismissible fade show\">
                        <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                        <h6 class=\"text-center\">Your email or password is wrong</h6>
                        </div>";
                    }

                        if(isset($_GET['csrf'])){
                            echo "<div class=\"alert alert-danger alert-dismissible fade show\">
                            <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                            <h6 class=\"text-center\">Invalid CSRF Token!</h6>
                            </div>";
                            } 
                            ?>
                        <h3 class="card-title text-center">Admin Login</h3>
                        <form action="db.php" method="post" class="need-validation" novalidate>
                            <div class="mb-3">
                                <label for="name" class="form-label text-muted">Username</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text"><i class="fa fa-user"></i></span>
                                    <input type="text" id="name" name="username" placeholder="Type your username" class="form-control" required>
                                    <div class="invalid-feedback">
                                        <p>Enter your username</p>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="pass" class="form-label text-muted">Password</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                        <input id="swp" type="password" name="pass" placeholder="Type your password" class="form-control" required>
                                        <span class="input-group-text" onclick="showpass()" title="show password"><i id="pass" class="fa fa-eye"></i></span>
                                        <input type="hidden" name="_csrf" value="<?php echo $_SESSION['csrf_token']; ?>">
                                        <div class="invalid-feedback">
                                            <p>Enter your password</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 mx-auto">
                                        <div class="g-recaptcha" data-sitekey="6LfnIrEkAAAAAE_Z1wZ_fL4Qvw3YROIJmpKFx49m"></div>
                                </div>
                                <div id="captcha" style="color: var(--bs-danger);"></div>
                                <a href="#forget" style="text-decoration: none;" class="text-muted card-subtitle">Forget password?</a>
                                <div class="d-grid mt-3 mb-3 gap-2">
                                    <button type="submit" name="submit" class="btn btn-primary">LOGIN</button>
                                </div>
                                <!-- <p class="card-subtitle text-center mt-5 text-muted">Or Sign Up Using</p>
                                <div class="mb-3 mt-3">
                                    <div class="d-flex justify-content-center">
                                        <i class="fa fa-facebook me-3"></i>
                                        <i class="fa fa-google me-3"></i>
                                        <i class="fa fa-twitter me-2"></i>
                                    </div>
                                </div> -->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
       </div>
    </div>
    <script>
        'use strict';
        var form=document.querySelectorAll("form");
        Array.from(form).forEach( form =>{
            form.addEventListener("submit",event =>{
                if(!form.checkValidity()){
                    event.stopPropagation();
                    event.preventDefault();
                }
                var captcha=grecaptcha.getResponse();
                if(captcha.length == 0 ){
                    event.stopPropagation();
                    event.preventDefault();
                    document.getElementById("captcha").innerText="Please Check Captcha";
                }
                form.classList.add("was-validated");
            })
        })

        function showpass(){
            var pass=document.getElementById("swp");
            var eye=document.getElementById("pass");
            if(pass.type == "password"){
                pass.type = "text";
                eye.classList.remove("fa-eye");
                eye.classList.add("fa-eye-slash");

            } else{
                pass.type = "password";
                eye.classList.remove("fa-eye-slash");
                eye.classList.add("fa-eye");
            }
        }
    </script>
    <script src="bootstrap-5.3.0-alpha1-dist/js/bootstrap.min.js"></script>
</body>
</html>