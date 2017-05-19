<?php

session_start();
require_once("../includes/RequireSSL.inc.php");
require_once("../classes/dao/VideosDao.class.php");
require_once("../includes/ReturnJSON.inc.php");

try {
    if (isset($_POST['tierLevel'])) {
        $daModTier = $_POST['tierLevel'];
        $module = VideoDao::Instance()->getVideosByTier($daModTier);
        if (count($module) >= 1) {
            print(json_encode($module));
        } else {
            throw new RuntimeException("No Video Found");
        }
    }
} catch (Exception $ex) {
    Website::handleError($ex);
}

