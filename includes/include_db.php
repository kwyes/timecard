<?php
  define("TIMECARD_DB_SERVER", "localhost");
  define("TIMECARD_DB_USERID", "dbname");
  define("TIMECARD_PASSWORD", "12345");
  define("TIMECARD_DB_NAME", "id6735578_timecard");

  // Generate connection variable
  // $TIMECARDinfo = array( "Database"=>TIMECARD_DB_NAME, "UID"=>TIMECARD_DB_USERID, "PWD"=>TIMECARD_PASSWORD, "CharacterSet" => "UTF-8");
  $conn_timecard = mysqli_connect(TIMECARD_DB_SERVER, TIMECARD_DB_USERID, TIMECARD_PASSWORD, TIMECARD_DB_NAME);
  mysqli_set_charset($conn_timecard,"utf8");

?>
