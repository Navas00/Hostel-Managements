<?php

define("salt",bin2hex(random_bytes(16)));


function get_hashed_pass($pass,$salt=salt){
    $pass=hash("sha256",$pass.$salt);
    $token=strrev(hash("sha256",$salt.$pass));
    $output=array(
        "salt" => salt,
        "token" => $token,
        "pass" => $pass
    );

    return json_encode($output);
}

$pass=$argv[1];
$res=get_hashed_pass($pass);
echo($res);

?>