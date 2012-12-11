<html>
<head>
<title>colorbox version</title>
<style type="text/css">
body { background:#111; }

.clear { clear:both; }
.photo-link img {border: 1px solid #ffffff; vertical-align:middle; padding:6px; margin:10px;}
.photo-link img:hover  { background: #000; border-color:#dbdbdb; }
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
$images_dir = 'images/gallery/test/';
$images_per_row = 2;

/** generate photo gallery **/
$image_files = get_files($images_dir);
if(count($image_files)) {
  $index = 0;
  foreach($image_files as $index=>$file) {
    $index++;
    echo '<a href="',$images_dir.$file,'" class="photo-link group1" rel="gallery"><img src="timthumb.php?src=',$images_dir.$file,'&h=200&w=200" /></a>';
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