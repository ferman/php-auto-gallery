<html>
<head>
<title>colorbox version</title>
<style type="text/css">
body { background:#111; }
#container {
width: 50%;
margin: 0 auto;
text-align: center;
background:#222;
position: relative;
}
.clear { clear:both; }
.photo-link img {border: 1px solid #333; vertical-align:middle; padding:6px; margin:10px; background: #111;}
.photo-link img:hover  { background: #000; border-color:#333 }
</style>
		<link rel="stylesheet" href="colorbox/colorbox.css" />
		<script src="colorbox/jquery.min.js"></script>
		<script src="colorbox/jquery.colorbox.js"></script>
		<script>
			$(document).ready(function(){
				$(".group1").colorbox({rel:'group1'});
			});
		</script>
 </head>
 <body>
 <div id="container">
 <?php
 /* function:  generates thumbnail */
function make_thumb($src,$dest,$desired_width) {
  /* read the source image */
  $source_image = imagecreatefromjpeg($src);
  $width = imagesx($source_image);
  $height = imagesy($source_image);
  /* find the "desired height" of this thumbnail, relative to the desired width  */
  $desired_height = floor($height*($desired_width/$width));
  /* create a new, "virtual" image */
  $virtual_image = imagecreatetruecolor($desired_width,$desired_height);
  /* copy source image at a resized size */
  imagecopyresized($virtual_image,$source_image,0,0,0,0,$desired_width,$desired_height,$width,$height);
  /* create the physical thumbnail image to its destination */
  imagejpeg($virtual_image,$dest);
}

/* function:  returns files from dir */
function get_files($images_dir,$exts = array('jpg')) {
  $files = array();
  if($handle = opendir($images_dir)) {
    while(false !== ($file = readdir($handle))) {
      $extension = strtolower(get_file_extension($file));
      if($extension && in_array($extension,$exts)) {
        $files[] = $file;
      }
    }
    closedir($handle);
  }
  return $files;
}

/* function:  returns a file's extension */
function get_file_extension($file_name) {
  return substr(strrchr($file_name,'.'),1);
}

/** settings **/
$images_dir = 'images/';
$thumbs_dir = 'thumbs/';
$thumbs_width = 200;
$images_per_row = 4;

/** generate photo gallery **/
$image_files = get_files($images_dir);
if(count($image_files)) {
  $index = 0;
  foreach($image_files as $index=>$file) {
    $index++;
    $thumbnail_image = $thumbs_dir.$file;
    if(!file_exists($thumbnail_image)) {
      $extension = get_file_extension($thumbnail_image);
      if($extension) {
        make_thumb($images_dir.$file,$thumbnail_image,$thumbs_width);
      }
    }
    echo '<a href="',$images_dir.$file,'" class="photo-link group1" rel="gallery"><img src="',$thumbnail_image,'" /></a>';
    if($index % $images_per_row == 0) { echo '<div class="clear"></div>'; }
  }
  echo '<div class="clear"></div>';
}
else {
  echo '<p>There are no images in this gallery.</p>';
}

 ?>
 </div>
 </body>
 </html>