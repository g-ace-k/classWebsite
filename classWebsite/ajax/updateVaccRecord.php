<?php

session_start();
require_once(dirname(__FILE__) . "/../includes/RequireSSL.inc.php");
require_once(dirname(__FILE__) . "/../includes/ReturnJSON.inc.php");
require_once(dirname(__FILE__) . "/../classes/services/DogService.class.php");

try {
    if (isset($_POST['dogid'])) {
        $dogId = $_POST['dogid'];
    }
    if (isset($_POST['rabies'])) {
        $rabies = $_POST['rabies'];
    } else {
        $rabies = null;
    }
    if (isset($_POST['parvovirus'])) {
        $parvovirus = $_POST['parvovirus'];
    } else {
        $parvovirus = null;
    }
    if (isset($_POST['distemper'])) {
        $distemper = $_POST['distemper'];
    } else {
        $distemper = null;
    }
    if (isset($_POST['hepatitis'])) {
        $hepatitis = $_POST['hepatitis'];
    } else {
        $hepatitis = null;
    }
    if (isset($_POST['measles'])) {
        $measles = $_POST['measles'];
    } else {
        $measles = null;
    }
    if (isset($_POST['cav2'])) {
        $cav2 = $_POST['cav2'];
    } else {
        $cav2 = null;
    }
    if (isset($_POST['parainfluenza'])) {
        $parainfluenza = $_POST['parainfluenza'];
    } else {
        $parainfluenza = null;
    }
    if (isset($_POST['bordetella'])) {
        $bordetella = $_POST['bordetella'];
    } else {
        $bordetella = null;
    }
    if (isset($_POST['leptospirosis'])) {
        $leptospirosis = $_POST['leptospirosis'];
    } else {
        $leptospirosis = null;
    }
    if (isset($_POST['coronavirus'])) {
        $coronavirus = $_POST['coronavirus'];
    } else {
        $coronavirus = null;
    }
    if (isset($_POST['lyme'])) {
        $lyme = $_POST['lyme'];
    } else {
        $lyme = null;
    }

    $vacc = new VaccRecord();
    $vacc->rabies = $rabies;
    $vacc->parvovirus = $parvovirus;
    $vacc->distemper = $distemper;
    $vacc->hepatitis = $hepatitis;
    $vacc->measles = $measles;
    $vacc->cav2 = $cav2;
    $vacc->parainfluenza = $parainfluenza;
    $vacc->bordetella = $bordetella;
    $vacc->leptospirosis = $leptospirosis;
    $vacc->coronavirus = $coronavirus;
    $vacc->lyme = $lyme;

    $response['querySuccess'] = DogService::Instance()->updateVaccRecordByDogId($dogId, $vacc);
    print(json_encode($response));
} catch (Exception $e) {
    Website::handleError($e);
}

