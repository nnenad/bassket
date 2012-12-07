<?php

// Example 21-2: header.php
session_start();
echo "<!DOCTYPE html>\n<html><head><script src='OSC.js'></script>";
include 'functions.php';

$automaticLogin = null;

$userstr = ' (Guest)';

if (isset($_COOKIE['basketToken'])) {
    $automaticLogin = $_COOKIE['basketToken'];
}
if ($automaticLogin != null) {
    $query = "SELECT * FROM userToken
            WHERE token=$automaticLogin";
    $result = queryMysql($query);

    if (mysql_num_rows($result) == 0) {
        
    } else {
        $rows = mysql_fetch_array($result);
        $playerId = $rows['playerId'];
        
        $query = "SELECT username,pass,playerId FROM player
                WHERE playerId = $playerId";
        if (mysql_num_rows($result) == 0) {
            
        } else {
            $query = "SELECT username,pass,playerId FROM player
            WHERE palyerId= $playerId";
            $result = queryMysql($query);
            $rows = mysql_fetch_array($result);
            $_SESSION['user'] = $rows['username'];
            $_SESSION['pass'] = $rows['pass'];
            $_SESSION['playerId'] = $rows['playerId'];
        }
    }
}

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    $loggedin = TRUE;
    $userstr = " ($user)";
}
else
    $loggedin = FALSE;

echo "<title>$appname$userstr</title><link rel='stylesheet' " .
 "href='styles.css' type='text/css' />" .
 "</head><body><div class='appname'>$appname$userstr</div>";

if ($loggedin) {
    echo "<br ><ul class='menu'>" .
    "<li><a href='members.php?view=$user'>Home</a></li>" .
    "<li><a href='members.php'>Members</a></li>" .
    "<li><a href='friends.php'>Friends</a></li>" .
    "<li><a href='messages.php'>Messages</a></li>" .
    "<li><a href='profile.php'>Edit Profile</a></li>" .
    "<li><a href='logout.php'>Log out</a></li></ul><br />";
} else {
    echo ("<br /><ul class='menu'>" .
    "<li><a href='index.php'>Home</a></li>" .
    "<li><a href='signup.php'>Sign up</a></li>" .
    "<li><a href='login.php'>Log in</a></li></ul><br />" .
    "<span class='info'>&#8658; You must be logged in to " .
    "view this page.</span><br /><br />");
}
?>
