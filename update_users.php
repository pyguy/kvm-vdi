<?php
include ('functions/config.php');
require_once('functions/functions.php');
if (!check_session()){
    header ("Location: $serviceurl/?error=1");
    exit;
}
slash_vars();
$type='';
if (isset($_POST['type']))
    $type=$_POST['type'];
if ($type=='new'){
    if (!empty($_POST['username']))
	$username=$_POST['username'];
    else{
	echo  'EMPTY_USER';
	exit;
    }
    if (!empty($_POST['password']))
	$password=$_POST['password'];
    else{
	echo  'EMPTY_PW';
	exit;
    }
    $existing=get_SQL_line("SELECT id FROM users WHERE username = '$username'");
    if (!empty($existing[0])){
	echo 'EXISTS';
	exit;
    }
    $password=crypt($password);
    add_SQL_line("INSERT INTO users (username,password) VALUES ('$username','$password')");
    echo 'SUCCESS';
    exit;
}
if ($type=='update-pw'){//using x-editable jQuery plugin, which uses different param naming
    $password=$_POST['password'];
    $id=$_POST['id'];
    $password=crypt($password);
    add_SQL_line("UPDATE users SET password='$password' WHERE id='$id' LIMIT 1");
    exit;
}
if ($type=='delete'){
    $user=$_POST['user'];
    foreach ($user as $id){
        add_SQL_line("DELETE FROM users WHERE id='$id' LIMIT 1");
    }
}
?>
