<?php
require_once('../../../../wp-load.php');

if (!is_user_logged_in()) {
    die(__("You do not have sufficient permissions to access this page."));
}

/**
*  Check the mime type of the file for 
*  avoid upload any dangerous file.
*  
*  @param string $mime is the type of file can be "image","audio" or "file"
*  @param string $file_type  is the mimetype of the field
*/
function valid_mime($file) {
    $mime = mime_content_type($file['tmp_name']);
    
    $exts = array(
      'image/gif',
      'image/jpeg',
      'image/pjpeg',
      'image/png',
      'image/x-png'
    );

    if ($mime == 'application/pdf') {
        return true;
    } else if (in_array($mime, $exts)) {
        return true;
    }
    
    return false;
}

function generateUUID() {
    return sprintf(
        '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
}

function generateRand() {
    return sprintf(
        '%04x%04x',
        mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
}

$resp = new stdClass();
$resp->id = generateUUID();
$resp->error = true;
$resp->msg = __("Upload Unsuccessful");

if (isset($_FILES['file']) && (!empty($_FILES['file']['tmp_name']))) {
    if ($_FILES['file']['error'] == UPLOAD_ERR_OK) {
        if (valid_mime($_FILES['file'])) {
                $special_chars = array(
                    ' ','`','"','\'','\\','/'," ","#","$","%","^","&",
                    "*","!","~","‘","\"","’","'","=","?","/","[","]",
                    "(",")","|","<",">",";","\\",",","+","-"
                );

                $filename = str_replace($special_chars, '_', $_FILES['file']['name']);
                $filename = preg_replace("/[^A-Za-z0-9_.]/", '_', $filename);
                $filename = generateRand().'_'.time().'_'.$filename;
                $path = 'uploads/ju4h-comments/'. date('Y').'/'.date('n').'/'.date('j').'/';
                $upload_path = WP_CONTENT_DIR.'/'.$path;

                if (!file_exists($upload_path)) {
                    mkdir($upload_path, 0777, true);
                }

                move_uploaded_file($_FILES['file']['tmp_name'], $upload_path.$filename);

                $resp->filepath = $path.$filename;
                $resp->filename = $_FILES['file']['name'];
                $resp->msg = __("Successful upload");
                $resp->error = false;
                
        } else {
            $resp->msg = __("File type not supported");
        }
    } else {
        $resp->msg = __("Upload Unsuccessful");
    }
} else if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_INI_SIZE) {
    $resp->msg = __('The uploaded file exceeds the maximum file size upload limit!');
}

echo json_encode($resp);