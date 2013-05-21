 <?php
 
 $MAX_WIDTH = 550;
 $MIN_WIDTH = 200;
 
 $md5 = $_GET['id'];
 $width = $_GET['w'];
 
 $path_original = 'cr/original/'.$md5;
 
 if (isValidMd5($md5) && file_exists($path_original)) {
     if ($width == '') {
         header("Content-type: image/jpeg");
         header("Content-Length: ". filesize($path_original));
         readfile($path_original);
     } else {
         if ($width < $MIN_WIDTH) $width = $MIN_WIDTH;
         if ($width > $MAX_WIDTH) $width = $MAX_WIDTH;
 
         header("Content-type: image/jpeg");
         $size = getimagesize($path_original);
         $size_w = $size[0];
         $size_h = $size[1];
         $im = @imagecreatefromjpeg($path_original);
         $new_w = $width;
         $new_h = intval($width*($size_h-72)/($size_w-84));
         $nim = $image_p = imagecreatetruecolor($new_w, $new_h);
         imagecopyresampled ($nim, $im, 0, 0, 42, 42, $new_w , $new_h , $size_w - 84 , $size_h - 72 );
         imagejpeg($nim, null, 50);
     }
 }
 
 function isValidMd5($md5) {
     return !empty($md5) && preg_match('/^[a-f0-9]{32}$/', $md5);
 }
 
 ?>
 
 
