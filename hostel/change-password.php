<?php

session_start();

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
    <title>Room details</title>
    <link rel="stylesheet" href="bootstrap-5.3.0-alpha1-dist/css/bootstrap.min.css">
    <style>
        html,body{
            height: 100%;
            width: 100%;
        }
        body{
            position: relative;
            background: url("study.jpg") center no-repeat;
            background-size: cover;
        }
        body::before{
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background-image: linear-gradient(to right bottom,#000,#000);
            opacity: 0.6;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 mx-auto mt-5">
                <div class="card">
                    <div class="card-body">
                        <form action="user.php" method="post" novalidate>
                            <div class="mt-3 mb-2 p-2">
                                <?php
                            if(isset($_GET['csrf'])){
                                    echo "<div class=\"alert alert-danger alert-dismissible fade show\">
                                          <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                                          <h4 class=\"text-center\">Invalid CSRF Token</h4>
                                          </div>";
                                    }

                                    ?>
                                <h5 class="card-title text-center">Change Password</h5>
                                <div class="card-subtitle text-muted text-center">
                                    <p>Password must contain at least 1 letter,1 number and 1 symbol.Minimum length is 12 characters.</p>
                                </div>
                                <h5 id="alert" class="text-danger text-center"></h5>
                                <label for="curpass" class="form-label text-muted">Current password</label>
                                <input type="password" class="form-control" name="cpass"  id="curpass" required>
                                <div class="invalid-feedback">
                                    <p>You must enter current password</p>
                                </div>
                            </div>
                            <div class="mb-2 p-2">
                                <label for="npass" class="form-label text-muted">New password</label>
                                <input type="password" id="npass" class="form-control" name="npass" required>
                                <div class="invalid-feedback">
                                    <p>Your must contain minimum 12 characters</p>
                                </div>
                            </div>
                            <div class="mb-2 p-2">
                                <label for="cpass" class="form-label text-muted">Confirm password</label>
                                <input type="password" id="cpass" class="form-control" required>
                                <input type="hidden" name="_csrf" value="<?php echo $_SESSION['csrf_token']; ?>">
                                <div class="invalid-feedback">
                                    <p>Your must contain minimum 12 characters</p>
                                </div>
                            </div>
                            <div class="d-grid mt-3">
                                <button name="chpass" class="btn btn-primary">Change</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="bootstrap-5.3.0-alpha1-dist/js/bootstrap.min.js"></script>
    <script>
        var forms = document.querySelectorAll("form");
            Array.from(forms).forEach(form => {
            form.addEventListener("submit", event => {
                if (!form.checkValidity()) {
                    event.stopPropagation();
                    event.preventDefault();
                }
                form.classList.add("was-validated");
            })
        })

        var old=window.location.search.substring(1);
        if(old == "old=1"){
            var ale=document.getElementById("alert");
            ale.innerText="Old Password Is Wronge";
        }
    </script>
</body>
</html>