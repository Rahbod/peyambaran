<?php
//$accepted_origins = array("http://localhost");

/*********************************************
 * Change this line to set the upload folder *
 *********************************************/
$date = date('Y-m-d', time());
$imageFolder = "uploads/editor-images/$date/";
if (!is_dir($imageFolder))
    mkdir($imageFolder, 0755, true);

reset($_FILES);
$temp = current($_FILES);

if (is_uploaded_file($temp['tmp_name'])) {
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        // same-origin requests won't set an origin. If the origin is set, it must be valid.
        header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
//        if (in_array($_SERVER['HTTP_ORIGIN'], $accepted_origins)) {
//            header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
//        } else {
//            header("HTTP/1.1 403 Origin Denied");
//            return;
//        }
    }

    /*
      If your script needs to receive cookies, set images_upload_credentials : true in
      the configuration and enable the following two headers.
    */
    // header('Access-Control-Allow-Credentials: true');
    // header('P3P: CP="There is no P3P policy."');

    // Sanitize input
    if (preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])) {
        header("HTTP/1.1 400 Invalid file name.");
        return;
    }

    // Verify extension
    if (!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "png"))) {
        header("HTTP/1.1 400 Invalid extension.");
        return;
    }

    // Accept upload if there was no origin, or if it is an accepted origin
    $filetowrite = $imageFolder . $temp['name'];
    move_uploaded_file($temp['tmp_name'], $filetowrite);

    // Respond to the successful upload with JSON.
    // Use a location key to specify the path to the saved image resource.
    // { location : '/your/uploaded/image/file'}
    echo json_encode(array('location' => getBaseUrl().'/'.$filetowrite));
} else {
    // Notify editor that the upload failed
    header("HTTP/1.1 500 Server Error");
}

function getBaseUrl()
{
    $scriptFile = $_SERVER['SCRIPT_FILENAME'];
    $scriptName = basename($scriptFile);
    if (isset($_SERVER['SCRIPT_NAME']) && basename($_SERVER['SCRIPT_NAME']) === $scriptName) {
        $surl = $_SERVER['SCRIPT_NAME'];
    } elseif (isset($_SERVER['PHP_SELF']) && basename($_SERVER['PHP_SELF']) === $scriptName) {
        $surl = $_SERVER['PHP_SELF'];
    } elseif (isset($_SERVER['ORIG_SCRIPT_NAME']) && basename($_SERVER['ORIG_SCRIPT_NAME']) === $scriptName) {
        $surl = $_SERVER['ORIG_SCRIPT_NAME'];
    } elseif (isset($_SERVER['PHP_SELF']) && ($pos = strpos($_SERVER['PHP_SELF'], '/' . $scriptName)) !== false) {
        $surl = substr($_SERVER['SCRIPT_NAME'], 0, $pos) . '/' . $scriptName;
    } elseif (!empty($_SERVER['DOCUMENT_ROOT']) && strpos($scriptFile, $_SERVER['DOCUMENT_ROOT']) === 0) {
        $surl = str_replace([$_SERVER['DOCUMENT_ROOT'], '\\'], ['', '/'], $scriptFile);
    } else {
        return '/';
    }
    return rtrim(dirname($surl), '\\/');
}