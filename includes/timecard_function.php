<?php
  include_once("general.php");
  include_once("include_db.php");
  include_once("common_class.php");
  session_start();

  function login_process($telNumber){
    $sql = "SELECT * FROM member WHERE contact = '$telNumber'";
    $result = timecard_mysql_query($sql);
    if (timecard_mysql_num_rows($result) == 1) {
      $data['status'] = "success";
        while($row = timecard_mysql_fetch_assoc($result)) {
          $data['name'] = $row['name'];
          $data['mId'] = $row['mId'];
        }
    } elseif (timecard_mysql_num_rows($result) > 1) {
      $data['status'] = "more";
      $namearr = array();
      $midarr = array();
        while($row = timecard_mysql_fetch_assoc($result)) {
          array_push($namearr, $row['name']);
          array_push($midarr, $row['mId']);
        }
      $data['name'] = $namearr;
      $data['mId'] = $midarr;
    } else {
      $data['status'] = "noname";
      $data['name'] = "";
      $data['mId'] = "";
    }
    $data = json_encode($data);
    print_r($data);
  }

  function admin_login_process($username, $password) {
   $username = addslashes($username);
   $password = addslashes($password);
   $query = "SELECT * FROM admin_member WHERE id = '$username' and pw = '$password'";
   $result = timecard_mysql_query($query);
   $row_num = timecard_mysql_num_rows($result);
   // echo $query;
   if($row_num > 0){
     $row = timecard_mysql_fetch_assoc($result);
     $_SESSION['timecardID'] = $row['id'];
     echo "success";
   } else {
     echo "failed";
   }

  }

  function insert_timecard_detail($telNumber,$mId){
    $today = date('Y-m-d');
    $today_time = date("Y-m-d H:i:s");
    $sql = "SELECT seq FROM login_tm WHERE phone = '$telNumber' and dt = '$today' and mId = '$mId'";
    $result = timecard_mysql_query($sql);
    $getName = get_name_from_number($telNumber, $mId);

    $typesql = "SELECT timecardType FROM company_info";
    $type_result = timecard_mysql_query($typesql);
    $type_row = timecard_mysql_fetch_assoc($type_result);
    $typeID = $type_row['timecardType'];

    if (timecard_mysql_num_rows($result) == 0) {
      $insert_sql = "INSERT INTO login_tm (seq, typeID, mId, phone, dt, in_dt, out_dt) VALUES (NULL, '$typeID', '$mId', '$telNumber', '$today', '$today_time', NULL)";
      $insert_result = timecard_mysql_query($insert_sql);
      $data['status'] = "success";
      $data['date'] = $today;
      $data['phone'] = $telNumber;
      $data['name'] = $getName;
      $data['chk'] = "0";
      $data['timecard_date'] = $today_time;
    } else {
      $update_sql = "UPDATE login_tm SET out_dt = '$today_time' WHERE phone = '$telNumber' AND mId = '$mId' AND dt = '$today'";
      $update_result = timecard_mysql_query($update_sql);
      $data['status'] = "success";
      $data['date'] = $today;
      $data['phone'] = $telNumber;
      $data['name'] = $getName;
      $data['chk'] = "1";
      $data['timecard_date'] = $today_time;
    }
    $data = json_encode($data);
    print_r($data);
    // echo 'success';
  }

  function fetch_company_info() {
    $infosql = "SELECT * FROM company_info";
    $info_result = timecard_mysql_query($infosql);
    $row = timecard_mysql_fetch_assoc($info_result);
    $data['companyName'] = $row['companyName'];
    $data['companyPhone'] = $row['companyPhone'];
    $data['companyAddress'] = $row['companyAddress'];
    $data['timecardType'] = $row['timecardType'];
    $data = json_encode($data);
    print_r($data);
  }

  function fetch_timecard_type($timecardType) {
    $sql = "SELECT * FROM login_tm_type order by typeID asc";
    $result = timecard_mysql_query($sql);
    $option = '';
    while ($row = timecard_mysql_fetch_assoc($result)) {
      $typeID = $row['typeID'];
      $typeName = $row['typeName'];
      if($typeID == $timecardType){
        $option_text = "value = $typeID selected";
      } else {
        $option_text = "value = $typeID";
      }
      $option .= "<option $option_text>$typeName</option>";
    }
    echo $option;
  }

  function fetch_timecard_type_register() {
    $sql = "SELECT * FROM login_tm_type order by typeID asc";
    $result = timecard_mysql_query($sql);
    $option = '';
    while ($row = timecard_mysql_fetch_assoc($result)) {
      $typeID = $row['typeID'];
      $typeName = $row['typeName'];

      $option .= "<li class='list-group-item t-li-$typeID'>$typeName<span onclick='delete_timecard_type($typeID)'>X</span></li>";
    }
    echo $option;
  }

  function delete_timecard_type($typeID) {
    $sql = "DELETE FROM login_tm_type WHERE typeID = '$typeID'";
    $result = timecard_mysql_query($sql);
  }

  function fetch_user_type_register($chk) {
    $sql = "SELECT * FROM member_type order by mTypeID asc";
    $result = timecard_mysql_query($sql);
    $option = '';
    if($chk == 2){
      $option .= "<option value='0'>User Type</option>";
    }
    while ($row = timecard_mysql_fetch_assoc($result)) {
      $typeID = $row['mTypeID'];
      $typeName = $row['mTypeName'];
      if($chk == '1') {
        $option .= "<li class='list-group-item u-li-$typeID'>$typeName<span onclick='delete_user_type($typeID)'>X</span></li>";
      } else {
        $option .= "<option value='$typeID'>$typeName</option>";
      }
    }
    echo $option;
  }

  function delete_user_type($typeID) {
    $sql = "DELETE FROM member_type WHERE mTypeID = '$typeID'";
    $result = timecard_mysql_query($sql);
  }

  function update_company_info($company_name,$company_phone,$company_address,$company_type_id) {
    $company_name = addslashes($company_name);
    $company_phone = addslashes($company_phone);
    $company_address = addslashes($company_address);
    $company_type_id = addslashes($company_type_id);
    $sql = "UPDATE company_info SET companyName = '$company_name', companyPhone = '$company_phone', companyAddress = '$company_address', timecardType = '$company_type_id'";
    $result = timecard_mysql_query($sql);
    // echo 'success';
  }

  function register_timecard_type($tType_value) {
    $tType_value = addslashes($tType_value);
    $getIDsql = "SELECT typeID FROM login_tm_type order by typeID desc limit 1";
    $getIDresult = timecard_mysql_query($getIDsql);
    $row = timecard_mysql_fetch_assoc($getIDresult);
    $typeID = $row['typeID'] + 1;


    $sql = "INSERT INTO login_tm_type(typeID, typeName) VALUES ('$typeID', '$tType_value')";
    $result = timecard_mysql_query($sql);
    $option = "<li class='list-group-item t-li-$typeID'>$tType_value<span onclick='delete_timecard_type($typeID)'>X</span></li>";

    echo $option;
  }

  function register_user_type($uType_value) {
    $uType_value = addslashes($uType_value);
    $getIDsql = "SELECT mTypeID FROM member_type order by mTypeID desc limit 1";
    $getIDresult = timecard_mysql_query($getIDsql);
    $row = timecard_mysql_fetch_assoc($getIDresult);
    $typeID = $row['mTypeID'] + 1;


    $sql = "INSERT INTO member_type(mTypeID, mTypeName) VALUES ('$typeID', '$uType_value')";
    $result = timecard_mysql_query($sql);
    $option = "<li class='list-group-item t-li-$typeID'>$uType_value<span onclick='delete_user_type($typeID)'>X</span></li>";

    echo $option;
  }

  function fetch_timecard_member() {
    $sql = "SELECT * FROM member order by mId asc";
    $result = timecard_mysql_query($sql);
    $option = '';
    while ($row = timecard_mysql_fetch_assoc($result)) {
      $name = $row['name'];
      $contact = $row['contact'];
      $mId = $row['mId'];
      $option .= "<tr><td>$name<input type='hidden' value='$mId' name='mid[]' class='mId'></td><td>$contact</td></tr>";
    }
    echo $option;
  }

  function register_user($member_name,$member_age,$member_school,$member_address,$member_emergencyname,$member_emergencycontact,$member_contact,$member_msp,$userRegister_select,$member_allergy,$member_memo) {
    $member_name = addslashes($member_name);
    $member_age = addslashes($member_age);
    $member_school = addslashes($member_school);
    $member_address = addslashes($member_address);
    $member_emergencyname = addslashes($member_emergencyname);
    $member_emergencycontact = addslashes($member_emergencycontact);
    $member_contact = addslashes($member_contact);
    $member_msp = addslashes($member_msp);
    $userRegister_select = addslashes($userRegister_select);
    $member_allergy = addslashes($member_allergy);
    $member_memo = addslashes($member_memo);
    $sql = "INSERT INTO member(name, age, school, address, emergencyname, emergencycontact, contact, msp, memberType, allergy, memo) ".
           "VALUES ('$member_name','$member_age','$member_school','$member_address','$member_emergencyname','$member_emergencycontact','$member_contact','$member_msp','$userRegister_select','$member_allergy','$member_memo')";
    $result = timecard_mysql_query($sql);
    echo 'success';
  }

  function update_user($member_mId, $member_name,$member_age,$member_school,$member_address,$member_emergencyname,$member_emergencycontact,$member_contact,$member_msp,$userRegister_select,$member_allergy,$member_memo) {
    $member_name = addslashes($member_name);
    $member_age = addslashes($member_age);
    $member_school = addslashes($member_school);
    $member_address = addslashes($member_address);
    $member_emergencyname = addslashes($member_emergencyname);
    $member_emergencycontact = addslashes($member_emergencycontact);
    $member_contact = addslashes($member_contact);
    $member_msp = addslashes($member_msp);
    $userRegister_select = addslashes($userRegister_select);
    $member_allergy = addslashes($member_allergy);
    $member_memo = addslashes($member_memo);
    $sql = "UPDATE member SET name='$member_name',age='$member_age', ".
           "school='$member_school',address='$member_address',emergencyname='$member_emergencyname', ".
           "emergencycontact='$member_emergencycontact',contact='$member_contact',allergy='$member_allergy', ".
           "msp='$member_msp',memberType='$userRegister_select',memo='$member_memo' WHERE mId = '$member_mId' ";
    $result = timecard_mysql_query($sql);
    echo 'success';
  }

  function fetch_timecard_member_detail($mId) {
    $sql = "SELECT * FROM member WHERE mId = '$mId'";
    $result = timecard_mysql_query($sql);
    $row = timecard_mysql_fetch_assoc($result);
    $mId = $row['mId'];
    $name = $row['name'];
    $age = $row['age'];
    $school = $row['school'];
    $address = $row['address'];
    $emergencyname = $row['emergencyname'];
    $emergencycontact = $row['emergencycontact'];
    $contact = $row['contact'];
    $allergy = $row['allergy'];
    $msp = $row['msp'];
    $memberType = $row['memberType'];
    $memo = $row['memo'];

    $data['mId'] = $mId;
    $data['name'] = $name;
    $data['age'] = $age;
    $data['school'] = $school;
    $data['address'] = $address;
    $data['emergencyname'] = $emergencyname;
    $data['emergencycontact'] = $emergencycontact;
    $data['contact'] = $contact;
    $data['allergy'] = $allergy;
    $data['msp'] = $msp;
    $data['memberType'] = $memberType;
    $data['memo'] = $memo;

    $data = json_encode($data);
    print_r($data);
  }

  function fetch_reports($today) {
   // if(!$today){
   //   $today = date('Y-m-d');
   // }
   $tr = "";
   $sql = "SELECT m.name, i.phone, i.dt, DATE_FORMAT(i.in_dt, '%H:%i:%s') as in_dt, DATE_FORMAT(i.out_dt, '%H:%i:%s') as out_dt, t.typeName FROM login_tm i ".
          "LEFT JOIN login_tm_type t on t.typeID = i.typeID ".
          "LEFT JOIN member as m on m.contact = i.phone AND m.mId = i.mId ".
          "WHERE i.dt = '$today' ORDER BY i.in_dt desc";
   $result = timecard_mysql_query($sql);
   while($row = timecard_mysql_fetch_assoc($result)){
     $phone = $row['phone'];
     $dt = $row['dt'];
     $dt = date("Y-m-d", strtotime($dt));
     $in_dt = $row['in_dt'];
     // $in_dt = date("h:m:s", strtotime($in_dt));
     $out_dt = $row['out_dt'];
     // $out_dt = date("h:m:s", strtotime($out_dt));
     $name = $row['name'];
     $typeName = $row['typeName'];
     $tr_class = '';
     if($out_dt){
       $duration = strtotime($out_dt) - strtotime($in_dt);
       $duration = gmdate("H:i:s", $duration);
       $tr_class = '';
     } else {
       $duration = '00:00:00';
       $tr_class= 'danger';
     }
     $tr .= "<tr class='$tr_class'>
     <td>
     $name
     </td>
     <td>
     $phone
     </td>
     <td>
     $dt
     </td>
     <td>
     $in_dt
     </td>
     <td>
     $out_dt
     </td>
     <td>
     $duration
     </td>
     <td>
     $typeName
     </td>
     </tr>";
   }
   echo $tr;
 }

 function reports_get_number($today){
   $sql = "SELECT count(*) total, sum(case when out_dt is NULL then 1 else 0 end) rest FROM login_tm WHERE dt = '$today'";
   $result = timecard_mysql_query($sql);
   $row = timecard_mysql_fetch_assoc($result);

   $data['total'] = $row['total'];
   $data['rest'] = $row['rest'];
   $data['incount'] = $row['total'] - $row['rest'];
   $data['query'] = $sql;
   $data = json_encode($data);
   print_r($data);
 }

  function delete_user($member_mId) {
    $sql = "DELETE FROM member WHERE mId = '$member_mId'";
    $result = timecard_mysql_query($sql);
  }

  $function = ($_GET['function']) ? $_GET['function'] : $_POST['function'];

  switch ($function) {

    case 'admin_login_process':
      $username = $_POST['username'];
      $password = $_POST['password'];
      admin_login_process($username, $password);
    break;

    case 'login_process':
      $telNumber = $_POST['telNumber'];
      login_process($telNumber);
    break;

    case 'insert_timecard_detail':
      $telNumber = $_POST['telNumber'];
      $mId = $_POST['mId'];
      insert_timecard_detail($telNumber,$mId);
    break;

    case 'fetch_company_info':
      fetch_company_info();
    break;

    case 'fetch_timecard_type':
      $timecardType = $_POST['timecardType'];
      fetch_timecard_type($timecardType);
    break;

    case 'update_company_info':
      $company_name = $_POST['company_name'];
      $company_phone = $_POST['company_phone'];
      $company_address = $_POST['company_address'];
      $company_type_id = $_POST['company_type_id'];
      update_company_info($company_name,$company_phone,$company_address,$company_type_id);
    break;

    case 'register_timecard_type':
      $tType_value = $_POST['tType_value'];
      register_timecard_type($tType_value);
    break;

    case 'fetch_timecard_type_register':
      fetch_timecard_type_register();
    break;

    case 'fetch_user_type_register':
      $chk = $_POST['chk'];
      fetch_user_type_register($chk);
    break;

    case 'delete_timecard_type':
      $typeID = $_POST['typeID'];
      delete_timecard_type($typeID);
    break;

    case 'delete_user_type':
      $typeID = $_POST['typeID'];
      delete_user_type($typeID);
    break;

    case 'register_user_type':
      $uType_value = $_POST['uType_value'];
      register_user_type($uType_value);
    break;

    case 'fetch_timecard_member':
      fetch_timecard_member();
    break;

    case 'register_user':
      $member_name = $_POST['member_name'];
      $member_age = $_POST['member_age'];
      $member_school = $_POST['member_school'];
      $member_address = $_POST['member_address'];
      $member_emergencyname = $_POST['member_emergencyname'];
      $member_emergencycontact = $_POST['member_emergencycontact'];
      $member_contact = $_POST['member_contact'];
      $member_msp = $_POST['member_msp'];
      $userRegister_select = $_POST['userRegister_select'];
      $member_allergy = $_POST['member_allergy'];
      $member_memo = $_POST['member_memo'];
      register_user($member_name,$member_age,$member_school,$member_address,$member_emergencyname,$member_emergencycontact,$member_contact,$member_msp,$userRegister_select,$member_allergy,$member_memo);
    break;

    case 'update_user':
      $member_mId = $_POST['member_mId'];
      $member_name = $_POST['member_name'];
      $member_age = $_POST['member_age'];
      $member_school = $_POST['member_school'];
      $member_address = $_POST['member_address'];
      $member_emergencyname = $_POST['member_emergencyname'];
      $member_emergencycontact = $_POST['member_emergencycontact'];
      $member_contact = $_POST['member_contact'];
      $member_msp = $_POST['member_msp'];
      $userRegister_select = $_POST['userRegister_select'];
      $member_allergy = $_POST['member_allergy'];
      $member_memo = $_POST['member_memo'];
      update_user($member_mId, $member_name,$member_age,$member_school,$member_address,$member_emergencyname,$member_emergencycontact,$member_contact,$member_msp,$userRegister_select,$member_allergy,$member_memo);
    break;

    case 'fetch_timecard_member_detail':
      $mId = $_POST['mId'];
      fetch_timecard_member_detail($mId);
    break;

    case 'fetch_reports':
      $today = $_POST['today'];
      fetch_reports($today);
    break;

    case 'reports_get_number':
      $today = $_POST['today'];
      reports_get_number($today);
    break;


    case 'delete_user':
      $member_mId = $_POST['member_mId'];
      delete_user($member_mId);
    break;

  }
?>
