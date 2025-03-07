<?php 

define("salt",bin2hex(random_bytes(16)));

function get_hashed_pass($pass,$salt=salt){
    return strrev(hash("sha256",$pass.$salt));

}

$pass=get_hashed_pass("admin");
echo "password ==> ".$pass;
echo "<br>salt ==> ".salt;
?>