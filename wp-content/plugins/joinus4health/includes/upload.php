<?php
require_once('../../../../wp-load.php');

$allowed_referers = array( //todo move to config
    get_site_url()."/wp-admin/post-new.php",
    get_site_url()."/wp-admin/post.php",
    get_site_url()."/wp-content/plugins/joinus4health/includes/upload.php"
);

$server_http_referer = explode('?', $_SERVER['HTTP_REFERER'])[0];
$is_allowed_referer = false;

foreach ($allowed_referers as $allowed_referer) {
    if (strlen($server_http_referer) >= strlen($allowed_referer) && substr($server_http_referer, 0, strlen($allowed_referer)) == $allowed_referer) {
        $is_allowed_referer = true;
    }
}

if (!$is_allowed_referer) {
    exit;
}


if (!current_user_can('upload_files')) {
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
    
    $imagesExts = array(
      'image/gif',
      'image/jpeg',
      'image/pjpeg',
      'image/png',
      'image/x-png'
    );
    
    $audioExts = array(
      'audio/mpeg',
      'audio/mpg',
      'audio/x-wav',
      'audio/mp3'
    );

    if ($mime == 'application/pdf') {
        return true;
    } else if (in_array($mime, $imagesExts)) {
        return true;
    }
    
    return false;
}

?>
<html>
    <head>
        <?php
        $get_id = htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8');
        $get_prefix = htmlspecialchars($_GET['prefix'], ENT_QUOTES, 'UTF-8');
        
        if (isset($_POST['fileframe'])) {
            $resp = new stdClass();
            $resp->id = $get_id;
            $resp->error = true;
            $resp->msg = __("Upload Unsuccessful");

            if (isset($_FILES['file']) && (!empty($_FILES['file']['tmp_name']))) {
                if ($_FILES['file']['error'] == UPLOAD_ERR_OK) {
                    if (valid_mime($_FILES['file'])) {
                        if (!wp_verify_nonce($_POST['checking'], 'nonce_upload_file')) {
                            $resp->msg = __('Sorry, your nonce did not verify.');
                        } else {
                            $special_chars = array(
                                ' ','`','"','\'','\\','/'," ","#","$","%","^","&",
                                "*","!","~","‘","\"","’","'","=","?","/","[","]",
                                "(",")","|","<",">",";","\\",",","+","-"
                            );
                            
                            $filename = str_replace($special_chars, '', $_FILES['file']['name']);
                            $filename = time().'_'.$filename;
                            $path = 'uploads/ju4h/'. date('Y').'/'.date('n').'/'.date('j').'/';
                            $upload_path = WP_CONTENT_DIR.'/'.$path;

                            if (!file_exists($upload_path)) {
                                mkdir($upload_path, 0777, true);
                            }

                            move_uploaded_file($_FILES['file']['tmp_name'], $upload_path.$filename);

                            $resp->filepath = $path.$filename;
                            $resp->filename = $filename;
                            $resp->msg = __("Successful upload");
                            $resp->error = false;
                        }
                    } else {
                        $resp->msg = __("File type not supported");
                    }
                } else if ($_FILES['file']['error'] == UPLOAD_ERR_INI_SIZE) {
                    $resp->msg = __('The uploaded file exceeds the maximum upload limit!');
                } else {
                    $resp->msg = __("Upload Unsuccessful");
                }
            }
            ?>
            <script type="text/javascript" charset="utf-8">
                var _par = window.parent;
                var _js = <?php echo json_encode($resp); ?>;
                _par.<?= $get_prefix ?>_handle_upload(_js);
            </script>
        <?php 
        }
        ?>

        <?php
        $get_type = htmlspecialchars($_GET['type'], ENT_QUOTES, 'UTF-8');
        
        // insert global admin stylesheet
        $admin_css = array('global.css', 'wp-admin.css'); // different stylesheets for different WP versions
        foreach ($admin_css as $c) {
            if (file_exists(ABSPATH.'/wp-admin/css/'.$c)) {
                echo '<link rel="stylesheet" href="'.get_bloginfo('wpurl').'/wp-admin/css/'.$c.'" type="text/css" />';
                break; // insert only one stylesheet
            }
        }
        ?>
        <style>
            body { padding: 0; margin: 0; vertical-align: top; background: transparent; font-size: 13px; }
            input { font-size: 13px; }
        </style>
        <script language="javascript">
            window.parent.document.getElementById('<?= $get_prefix ?>-iframe-upload-<?= $get_id ?>').style.display = "block";
            
            function upload() {
                var par = window.parent.document;
                var iframe = par.getElementById('<?= $get_prefix ?>-iframe-upload-<?= $get_id ?>');
                
                if (iframe == null) {
                    alert("Can't perform upload");
                    return;
                }

                iframe.style.display = "none";
                par.getElementById("<?= $get_prefix ?>-status-iframe-upload-<?= $get_id ?>").style.display = "block";
                par.getElementById("<?= $get_prefix ?>-status-iframe-upload-<?= $get_id ?>").innerHTML = "Transferring ";
                setTimeout(function(){ transferring(0); }, 1000);
                document.iform.submit();
            }
            
            function transferring(dots) {
                newString = "Transferring ";
                for (var x=1; x<=dots; x++) {
                    newString = newString + ".";
                }
                
                var par = window.parent.document;
                
                if (par.getElementById("<?= $get_prefix ?>-status-iframe-upload-<?= $get_id ?>").innerHTML.substring(0,5) != "Trans") {
                    return;
                }
                
                par.getElementById("<?= $get_prefix ?>-status-iframe-upload-<?= $get_id ?>").innerHTML = newString;
                
                if (dots == 4) { 
                    dots = 0; 
                } else {
                    dots = dots + 1;
                }
                
                setTimeout(function(){ transferring(dots); }, 1000);
            }
        </script>
    </head>
    <body>
        <form name="iform" action="" method="post" enctype="multipart/form-data">
            <?php wp_nonce_field('nonce_upload_file', 'checking') ?>
            <label for="file"><?= __('File') ?>:</label>&nbsp;&nbsp;&nbsp;
            <input id="file" type="file" name="file" onchange="upload()" />
            <input type="hidden" name="id" value="<?= $get_id ?>" />
            <input type="hidden" name="type" value="<?= $get_type ?>" />
            <input type="hidden" name="fileframe" value="true" />
        </form>
    </body>
</html>