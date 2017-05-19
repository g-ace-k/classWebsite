<?php

require_once(dirname(__FILE__) . "/../dao/DogDao.class.php");
require_once(dirname(__FILE__) . "/../dao/UserDao.class.php");
require_once(dirname(__FILE__) . "/../Singleton.class.php");
require_once(dirname(__FILE__) . "/../model/Dog.class.php");
require_once(dirname(__FILE__) . "/../model/User.class.php");
require_once(dirname(__FILE__) . "/../dao/VeterinarianClinicDao.class.php");
require_once(dirname(__FILE__) . "/../model/VeterinarianClinic.class.php");
require_once(dirname(__FILE__) . "/../dao/VaccRecordDao.class.php");
require_once(dirname(__FILE__) . "/../model/VaccRecord.class.php");
require_once(dirname(__FILE__) . "/../exceptions/InvalidInputException.class.php");
require_once(dirname(__FILE__) . "/../dao/VideosDao.class.php");

/**
 * Description of DogService
 *
 * @author servicetemp
 */
class DogService extends Singleton {

    public function approveDogNextLevel($dog) {
        $num = VideoDao::Instance()->getNumOfTiers();
        if ($dog->level < $num) {
            $dog->incrementLevel();
            $dResponse = DogDao::Instance()->updateDogLevel($dog);
            $response["dog"] = $dog;
            $response["updated"] = $dResponse ;
        } else {
            throw new RuntimeException("Dog is already at max level");
        }
        return $response;
    }

    public function getDogAndUser($dogName) {
        $dogsResponse = DogDao::Instance()->getDogByName($dogName);
        foreach ($dogsResponse as $dog) {
            $userResponse = UserDao::Instance()->getUserByUserID($dog->userID);
            $dog->setUser($userResponse);
        }
        return $dogsResponse;
    }

    public function getDogUserAndClinic($dogName) {
        $dogsResponse = DogDao::Instance()->getDogByName($dogName);
        foreach ($dogsResponse as $dog) {
            $userResponse = UserDao::Instance()->getUserByUserID($dog->userID);
            $clinicResponse = VeterinarianClinicDao::Instance()->getVetClinicById($dog->veternarianID);
            $dog->setUser($userResponse);
            $dog->setVetClinic($clinicResponse);
        }
        return $dogsResponse;
    }

    public function getDogID($dogId) {
        $dogsResponse = DogDao::Instance()->getDogByDogId($dogId);
        foreach ($dogsResponse as $dog) {
            $userResponse = UserDao::Instance()->getUserByUserID($dog->userID);
            $clinicResponse = VeterinarianClinicDao::Instance()->getVetClinicById($dog->veternarianID);
            $dog->setUser($userResponse);
            $dog->setVetClinic($clinicResponse);
        }
        return $dogsResponse;
    }

    public function getVetClinicAndVaccRecordByUser($userID) {
        $dogsResponse = DogDao::Instance()->getDogByUser($userID);

        foreach ($dogsResponse as $dog) {
            $vaccResponse = VaccRecordDao::Instance()->getVaccRecordByDog($dog->vaccID);
            $clinicResponse = VeterinarianClinicDao::Instance()->getVetClinicById($dog->veternarianID);
            $dog->setVaccRecord($vaccResponse);
            $dog->setVetClinic($clinicResponse);
        }
        return $dogsResponse;
    }

    public function getVetClinicAndVaccRecordByDog($dogID) {
        $dog = DogDao::Instance()->getDogByDogId($dogID);
        $vaccResponse = VaccRecordDao::Instance()->getVaccRecordByDog($dog->vaccID);
        $clinicResponse = VeterinarianClinicDao::Instance()->getVetClinicById($dog->veternarianID);
        $dog->setVaccRecord($vaccResponse);
        $dog->setVetClinic($clinicResponse);
        return $dog;
    }

    public function getAllDogUserAndClinic() {
        $dogsResponse = DogDao::Instance()->getAllDogs();
        foreach ($dogsResponse as $dog) {
            $userResponse = UserDao::Instance()->getUserByUserID($dog->userID);
            $clinicResponse = VeterinarianClinicDao::Instance()->getVetClinicById($dog->veternarianID);
            $dog->setUser($userResponse);
            $dog->setVetClinic($clinicResponse);
        }
        return $dogsResponse;
    }
    
    public function getAllInactiveDogUserAndClinic() {
        $dogsResponse = DogDao::Instance()->getAllInactiveDogs();
        foreach ($dogsResponse as $dog) {
            $userResponse = UserDao::Instance()->getUserByUserID($dog->userID);
            $clinicResponse = VeterinarianClinicDao::Instance()->getVetClinicById($dog->veternarianID);
            $dog->setUser($userResponse);
            $dog->setVetClinic($clinicResponse);
        }
        return $dogsResponse;
    }

    public function updateVaccRecordByDogId($dogId, $vacc) {
        $dog = DogDao::Instance()->getDogByDogId($dogId);
        return VaccRecordDao::Instance()->updateVaccRecordByVaccId($dog->vaccID, $vacc->rabies, $vacc->parvovirus, $vacc->distemper, $vacc->hepatitis, $vacc->measles, $vacc->cav2, $vacc->parainfluenza, $vacc->bordetella, $vacc->leptospirosis, $vacc->coronavirus, $vacc->lyme);
    }

    public function checkDogBeforeAdding($dog, $vetClinic, $dogDate) {
        if (strlen($dog->certNo) > 12) {
            throw new InvalidInputException("Certification Number is too long");
        }
        if (strlen($dog->chipNo) > 32) {
            throw new InvalidInputException("Dog Chip Number is too long");
        }
        $clinicResponse = VeterinarianClinicDao::Instance()->getVeterinarianClinicByName($vetClinic);
        $vetId = $clinicResponse[0]->veterinarianId;
        $dog->veternarianID = $vetId;

        return DogDao::Instance()->addDog($dog->certNo, $dog->chipNo, $dog->dogName, $dogDate, $dog->breed, $dog->notes, $dog->targetTrainingLevel, $dog->veternarianID);
    }

}
