<?php

session_start();
require_once("../includes/RequireSSL.inc.php");
require_once("../classes/dao/VideosDao.class.php");
require_once("../includes/ReturnJSON.inc.php");

$tier = VideoDao::Instance()->getNumOfTiers();
print(json_encode($tier));
