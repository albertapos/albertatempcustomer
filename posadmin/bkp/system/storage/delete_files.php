<?php

$files_export = glob('exprot_db/*'); // get all file names

foreach($files_export as $file_export){ 
  if(is_file($file_export))
    unlink($file_export); 
}

$files_import = glob('import_bakcup/*'); // get all file names

foreach($files_import as $file_import){
  if(is_file($file_import))
    unlink($file_import); 
}

$files_uploaded = glob('uploaded_db/*'); // get all file names

foreach($files_uploaded as $file_uploaded){ 
  if(is_file($file_uploaded))
    unlink($file_uploaded); 
}

echo "yes done";
exit;
?>