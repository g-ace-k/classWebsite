<?php

session_start();
require_once(dirname(__FILE__) . "/../includes/RequireSSL.inc.php");
require_once(dirname(__FILE__) . "/../classes/dao/VideosDao.class.php");
require_once(dirname(__FILE__) . "/../includes/ReturnJSON.inc.php");

try
{
    if (!empty($_POST['updateVName']) && !empty($_POST['updateVTier']) && !empty($_POST['updateVURL']) && !empty($_POST['updateVNotes']) && !empty($_POST['updateVID'])) 
    {

        if (isset($_POST['updateVName'])) 
        {
            $UpdateName = $_POST['updateVName'];
        }
        if (isset($_POST['updateVTier'])) 
        {
            $UpdateTier = $_POST['updateVTier'];
        }
        if (isset($_POST['updateVChoice'])) 
        {
            $UpdateHidden = $_POST['updateVChoice'];
        }
        if (isset($_POST['updateVNotes'])) 
        {
            $UpdateNotes = $_POST['updateVNotes'];
        }
        if (isset($_POST['updateVURL'])) 
        {
            $UpdateLink = $_POST['updateVURL'];
        }
        if (isset($_POST['updateVID'])) 
        {
            $UpdateID = $_POST['updateVID'];
        }

        $response['querySuccess'] = VideoDao::Instance()->updateModule($UpdateLink, $UpdateTier, $UpdateHidden, $UpdateNotes, $UpdateName, $UpdateID);
        print(json_encode($response));
    } else 
    {
        throw new Exception("Failed to update Module. Did not fill in all fields");
    }
} catch (Exception $ex) {
    Website::handleError($ex);
}

