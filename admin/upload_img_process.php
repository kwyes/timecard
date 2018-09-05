<?php
function return_bytes($val) {
  $val = trim($val);
  $last = strtolower($val[strlen($val)-1]);
  switch($last) {
      // The 'G' modifier is available since PHP 5.1.0
      case 'g':
          $val *= 1024;
      case 'm':
          $val *= 1024;
      case 'k':
          $val *= 1024;
  }

  return $val;
}

function makeThumbnails($updir, $img, $id) {
  $fn = $updir . $id . '_' . $img;
  $size = getimagesize($fn);
  $ratio = $size[0]/$size[1]; // width/height
  if( $ratio > 1) {
      $width = 150;
      $height = 150/$ratio;
  }
  else {
      $width = 150*$ratio;
      $height = 150;
  }
  $src = imagecreatefromstring(file_get_contents($fn));
  $dst = imagecreatetruecolor($width,$height);
  imagecopyresampled($dst,$src,0,0,0,0,$width,$height,$size[0],$size[1]);
  imagedestroy($src);
  imagepng($dst, $updir . $id . '_thumb' . $img); // adjust format as needed
  imagedestroy($dst);

  return $id . '_thumb' . $img;
}

if (isset($_FILES['fileUpload'])) {

// този цикъл е ако пращате наведнъж файловете, иначе са един по един
//    for ($i=0; $i< count($_FILES['fileUpload']['tmp_name']); $i++) {


  $id = rand(10000,20000);
  $uploaddir = '../bg/';
  $filename = str_replace(' ', '-', $_FILES['fileUpload']['name']);
  $filename = preg_replace('/[^a-zA-Z0-9\._-]+/i', '', $filename);
  $realfilename = 'bg.jpg';
  $uploadfile = $uploaddir . $realfilename;

  $errors     = array();
  $maxsize    = 5097152; // 2097152 = 2MB
  $phpmaxsize = return_bytes(ini_get('post_max_size')); // return in bytes else in megabytes
  $acceptable = array(
      'image/jpeg',
      'image/jpg',
      'image/gif',
      'image/png'
  );

  if(($_FILES['fileUpload']['size'] >= $maxsize) || ($_FILES["fileUpload"]["size"] == 0) || ($_FILES['fileUpload']['size'] >= $phpmaxsize)) {
      $errors[] = 'File too large. File must be less than 5 megabytes.'.$_FILES['fileUpload']['size'];
  }

  if(!in_array($_FILES['fileUpload']['type'], $acceptable) && (!empty($_FILES['fileUpload']["type"]))) {
      $errors[] = 'Invalid file type. Only JPG, GIF and PNG types are accepted.';
  }

  if(count($errors) === 0) {
      if (move_uploaded_file($_FILES['fileUpload']['tmp_name'], $uploadfile)) {
          // $thumb = makeThumbnails($uploaddir, $realfilename, $id);
          // echo "File is valid, and was successfully uploaded.\n";
          echo '<script type="text/javascript">
           window.location = "/admin"
           </script>';
      } else {
          echo "Possible file upload attack!\n";
      }
  } else {
      foreach($errors as $error) {
          echo '<p>' . $error . '</p>';
      }
      //die(); //Ensure no more processing is done
  }

  //} //end for

  // echo 'Here is some more debugging info:';
  // print_r($_FILES);
} else {
  die('send files');
}
?>
