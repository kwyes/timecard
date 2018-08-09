<?php
  include_once('include_db.php');

  function timecard_mysql_query($sql){
    global $conn_timecard;
    if($sql) {
      $result = mysqli_query($conn_timecard, $sql);
    }
    return $result;
    mysqli_close($conn_timecard);
  }

  function timecard_mysql_num_rows($result){
    if($result) {
      $num_rows = mysqli_num_rows($result);
    }
    return $num_rows;
  }

  function timecard_mysql_fetch_assoc($result) {
      $this_result = mysqli_fetch_assoc($result);
      return $this_result;
  }

  function get_name_from_number($telNumber) {
    $sql = "SELECT name FROM member WHERE contact = '$telNumber'";
    $result = timecard_mysql_query($sql);
    $this_result = timecard_mysql_fetch_assoc($result);
    return $this_result['name'];
  }



?>
