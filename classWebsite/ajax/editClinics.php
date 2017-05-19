<?php

session_start();
require_once(dirname(__FILE__) . "/../includes/RequireSSL.inc.php");
require_once(dirname(__FILE__) . "/../classes/dao/VeterinarianClinicDao.class.php");
require_once(dirname(__FILE__) . "/../includes/ReturnJSON.inc.php");



    try {
        
                if (!empty($_POST['ClinicName']) 
         &&!empty($_POST['StreetAddress']) 
        &&!empty($_POST['City']) &&!empty($_POST['State']) &&!empty($_POST['Zipcode'])
        &&!empty($_POST['PhoneNumber']))
        {
                    if (isset($_POST['ClinicName']) && isset($_POST['StreetAddress']) &&
            isset($_POST['City']) && isset($_POST['State']) && isset($_POST['Zipcode'])
                            && isset($_POST['PhoneNumber'])) 
    {
                $ClinicName = $_POST['ClinicName'];
                $StreetAddress=$_POST['StreetAddress'];
                $State=$_POST['State'];
                $City=$_POST['City'];
                $Zipcode=$_POST['Zipcode'];
                $PhoneNumber=$_POST['PhoneNumber'];
                $VeterinarianId=$_POST['VeterinarianId'];
                
                $response['querySuccess'] = VeterinarianClinicDao::Instance()->confirmedEditOfClinicRow($ClinicName, $StreetAddress, $State, $City, $Zipcode, $PhoneNumber,$VeterinarianId);

                print(json_encode($response));
        
    }
    }} catch (Exception $e) {
    Website::handleError($e);
}