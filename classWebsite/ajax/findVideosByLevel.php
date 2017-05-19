<?php

session_start();
require_once("../includes/RequireSSL.inc.php");
require_once("../classes/dao/VideosDao.class.php");
require_once("../includes/ReturnJSON.inc.php");

if (isset($_POST['level'])) {
    $level = $_POST['level'];

    $videos = VideoDao::Instance()->getNonHiddenVideosByTier($level);
    print(json_encode($videos));
}

