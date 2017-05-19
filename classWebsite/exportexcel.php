<?php

require_once(dirname(__FILE__) . "/classes/dao/DogDao.class.php");
require_once(dirname(__FILE__) . "/classes/dao/VeterinarianClinicDao.class.php");
require_once(dirname(__FILE__) . "/classes/dao/UserDao.class.php");
require_once(dirname(__FILE__) . "/classes/services/ReportService.class.php");
require_once(dirname(__FILE__) . "/includes/CheckAdminPriv.inc.php");

//$level = $_POST['doglevel'];
//$z = "Select * from `dog` where level = $level ";
$selection = $_POST['selection'];
if ($selection == 'dog') {
    $level = $_POST['doglevel'];
    $breed = $_POST['dogbreed'];
    $trainlevel = $_POST['dogtraininglevel'];
    $vaccident = $_POST['vaccid'];
    $vetident = $_POST['vetid'];
    $rowSelection = DogDao::Instance()->getDogQuery($level,$breed,$trainlevel,$vaccident,$vetident);
} else if ($selection == 'user') {
   
    $username = $_POST['username'];
    $userfname = $_POST['fname'];
    $userlname = $_POST['lname'];
    $useremailaddress = $_POST['useremail'];
    $usercity = $_POST['usercity'];
    $userstate = $_POST['userstate'];
    $userzip = $_POST['userzip'];
    $rowSelection = UserDao::Instance()->getUserQuery($username,$userfname,$userlname,$useremailaddress,$usercity,$userstate,$userzip); 
} else if ($selection == 'vet') {
    $vetstate = $_POST['vetstate'];
    $vetzip = $_POST['vetzip'];
    $vetcity = $_POST['vetcity'];
    $rowSelection = VeterinarianClinicDao::Instance()->getVetQuery($vetstate, $vetzip, $vetcity);  
}
//query built, now sent to DB 
$result = DatabaseFactory::getOnePetOneVetDB()->mysql->query($rowSelection);
//pass rows to excel service
ReportService::Instance()->generateReports($result);

?>