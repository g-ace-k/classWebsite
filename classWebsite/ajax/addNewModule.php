<?php

session_start();
require_once(dirname(__FILE__) . "/../includes/RequireSSL.inc.php");
require_once(dirname(__FILE__) . "/../classes/dao/VideosDao.class.php");
require_once(dirname(__FILE__) . "/../includes/ReturnJSON.inc.php");

try 
{
    if (!empty($_POST['vURL']) && !empty($_POST['vTier']) && !empty($_POST['vNotes']) && !empty($_POST['vName'])) 
    {
        if(isset($_POST['vURL']))
        {
            $VideoLink = $_POST['vURL']; 
        }
        if(isset($_POST['vTier']))
        {
            $TierLevel = $_POST['vTier'];
        }
        if(isset($_POST['vHidden']))
        {
            $Hidden = $_POST['vHidden'];
        }
        if(isset($_POST['vNotes']))
        {
            $VideoNotes = $_POST['vNotes'];
        }
        if(isset($_POST['vName']))
        {
            $VideoName = $_POST['vName'];
        }

        $response['querySuccess'] = VideoDao::Instance()->addVideo($VideoLink, $TierLevel, $Hidden, $VideoNotes, $VideoName);
        
        print(json_encode($response));
    } else 
    {
         throw new Exception("Failed to add Module. Did not fill in all fields");
    }
} catch (Exception $ex) {
    Website::handleError($ex);
}






