<?php
/* ===========================================================
 * trumbowyg.upload.php
 * Upload plugin for Trumbowyg
 * http://alex-d.github.com/Trumbowyg
 * ===========================================================
 * Author : Alexandre Demode (Alex-D)
 *          Twitter : @AlexandreDemode
 *          Website : alex-d.fr
 * ===========================================================
 * /!\ This file was make just for tests. Do not use it in
 *     production because it is not secure.
 */



/**
 * Upload directory
 */
define("UPLOADDIR", "../images/report/");



// Detect if it is an AJAX request
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $file = array_shift($_FILES);
    $ext = explode('.',basename($file['name']));
    $name = uniqid().".".$ext[1];
    if(move_uploaded_file($file['tmp_name'], UPLOADDIR . $name)) {
        $file = dirname($_SERVER['PHP_SELF']) . '/' . UPLOADDIR . $name;
        $data = array(
            'message' => 'uploadSuccess',
            'file'    => $file,
        );
    } else {
        $error = true;
        $data = array(
            'message' => 'uploadError',
        );
    }
} else {
    $data = array(
        'message' => 'uploadNotAjax',
        'formData' => $_POST
    );
}



echo json_encode($data);