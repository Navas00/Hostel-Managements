<?php

if(session_status() == PHP_SESSION_ACTIVE){
    //
} else{
    session_start();
}

if(!isset($_SESSION['csrf_token'])){
    $_SESSION['csrf_token']=bin2hex(random_bytes(32));
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student login</title>
    <link rel="stylesheet" href="bootstrap-5.3.0-alpha1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="student_login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://www.google.com/recaptcha/api.js"></script>

</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-5 mx-auto mt-5 pb-5">
                <div class="card mt-5 p-4 text-dark">
                    <div class="card-body">
                        <?php
                        $alert=empty($_GET['failed']) ? "null" : $_GET['failed'];
                        if($alert != "null"){
                            echo "<div class=\"alert alert-danger alert-dismissible fade show\">
                                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                                <h6 class=\"text-center\">Your email or password is wrong</h6>
                                </div>";
                        }
                        $alert=empty($_GET['csrf']) ? "null" : $_GET['csrf'];
                        if($alert != "null"){
                            echo "<div class=\"alert alert-danger alert-dismissible fade show\">
                                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                                <h6 class=\"text-center\">Invalid CSRF Token!</h6>
                                </div>";
                        }
                        ?>
                        <form action="user.php" method="post" novalidate>
                            <h2 class="text-center card-title">Login</h5>
                                <div class="mb-3">
                                    <label for="email" class="form-label text-muted">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                                        <input type="email" placeholder="example@gmail.com" id="email" name="email" class="form-control" required>
                                        <div class="invalid-feedback">
                                            <p>Enter Your Email</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label text-muted">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                        <input type="password" id="swp" class="form-control" placeholder="password" id="password" name="pass" required>
                                        <span class="input-group-text" onclick="showpass()" title="show password"><i id="pass" class="fa fa-eye"></i></span>
                                        <div class="invalid-feedback">
                                            <p>Enter Your Email</p>
                                        </div>
                                    </div>
                                    <input type="hidden" name="_csrf" value="<?php echo $_SESSION['csrf_token']; ?>">
                                </div>
                                <div class="mb-3 mx-auto">
                                        <div class="g-recaptcha" data-sitekey="6LfnIrEkAAAAAE_Z1wZ_fL4Qvw3YROIJmpKFx49m"></div>
                                        <p id="captcha" style="color: var(--bs-danger);"></p>
                                    </div>
                                <div class="d-grid mt-4 mb-2 gap-2">
                                    <button name="login" class="btn btn-primary">Login</button>
                                </div>
                                <a style="text-decoration: none;" href="#" class="text-muted card-subtitle">Forget password?</a><br><br>
                                <a href="register.html" class="text-muted d-flex justify-content-center text-center card-subtitle text-decoration-none">Or register</a>
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
                var response=grecaptcha.getResponse();
            if(response.length == 0){
                event.preventDefault();
                console.log("captcha not checked");
                document.getElementById("captcha").innerText="Please Check Captcha";
            } else{
                console.log("captcha checked");
            }
                form.classList.add("was-validated");
            })
        })

        if(localStorage.getItem("rollno")){
            localStorage.removeItem("rollno");
        }

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
</body>
</html>