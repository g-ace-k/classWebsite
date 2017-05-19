<?php

session_start();
require_once(dirname(__FILE__) . "/../includes/RequireSSL.inc.php");
require_once(dirname(__FILE__) . "/../classes/dao/VideosDao.class.php");
require_once(dirname(__FILE__) . "/../includes/ReturnJSON.inc.php");

/*
 * ajax function that will delete a video from the database
 */

try {
    if (!empty($_POST['videoId'])) {
        $videoId = $_POST['videoId'];

        $response['querySuccess'] = VideoDao::Instance()->deleteModuleById($videoId);
        print(json_encode($response));
    } else {
        throw new Exception("Failed to delete Module.");
    }
} catch (Exception $ex) {
    Website::handleError($ex);
}