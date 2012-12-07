<?php

// Example 21-1: functions.php
$dbhost = 'localhost';    // Unlikely to require changing
$dbname = 'rndata';       // Modify these...
$dbuser = 'root';   // ...variables according
$dbpass = '';   // ...to your installation
$appname = "Play basket"; // ...and preference

mysql_connect($dbhost, $dbuser, $dbpass) or die(mysql_error());
mysql_select_db($dbname) or die(mysql_error());

function createTable($name, $query, $engine) {
    queryMysql("CREATE TABLE IF NOT EXISTS $name($query)$engine");
    echo "Table '$name' created or already exists.<br />";
}

function getSetRandomToken($result) {
    $tokenNumber = rand();
    $query = "SELECT * FROM userToken
            WHERE token = $tokenNumber";

    if (mysql_num_rows(queryMysql($query)) == 0) {
        $row = mysql_fetch_array( $result );
        $playerId = $row['playerId'];
       queryMysql("INSERT INTO userToken VALUES( $tokenNumber, $playerId)");
       return $tokenNumber;
    } else {
         getSetRandomToken($result);
    }
}

function queryMysql($query) {
    $result = mysql_query($query) or die(mysql_error());
    return $result;
}

function destroySession() {
    $_SESSION = array();

    if (session_id() != "" || isset($_COOKIE[session_name()]))
        setcookie(session_name(), '', time() - 2592000, '/');

    session_destroy();
}

function sanitizeString($var) {
    $var = strip_tags($var);
    $var = htmlentities($var);
    $var = stripslashes($var);
    return mysql_real_escape_string($var);
}

function showProfile($user) {
    if (file_exists("$user.jpg"))
        echo "<img src='$user.jpg' align='left' />";

    $result = queryMysql("SELECT * FROM profiles WHERE user='$user'");

    if (mysql_num_rows($result)) {
        $row = mysql_fetch_row($result);
        echo stripslashes($row[1]) . "<br clear=left /><br />";
    }
}

?>
