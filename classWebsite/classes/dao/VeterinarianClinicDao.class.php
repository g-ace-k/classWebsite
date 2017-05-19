<?php

require_once(dirname(__FILE__) . "/../db/DatabaseFactory.class.php");
require_once(dirname(__FILE__) . "/../model/VeterinarianClinic.class.php");
require_once(dirname(__FILE__) . "/../Singleton.class.php");
require_once(dirname(__FILE__) . "/BaseDao.class.php");

/**
 * This Dao is used for VeterinarianClinic functions and relations
 * @author Michael Gacek 2/19/16
 */
class VeterinarianClinicDao extends BaseDao {

    private $columnNames = "ClinicName,VeterinarianId,StreetAddress,State,City,Zipcode,PhoneNumber ";
    /**
     * 
     * @param type $veterinarianId
     * @return type
     * @throws RuntimeException
     */
    public function getVeterinarianClinicByDog($veterinarianId) {
        $query = sprintf("SELECT $this->columnNames "
                . "FROM `veterinarianclinic` WHERE VeterinarianId='%s'", addslashes($veterinarianId));
        $result = DatabaseFactory::getOnePetOneVetDB()->mysql->query($query);
        if ($result->num_rows == 1) {
            return $this->convertRow($result->fetch_assoc());
        } else {
            throw new RuntimeException("Veterinarian clinic not found");
        }
    }

    /**
     * 
     * @param type $clinicID
     * @return type
     * @throws RuntimeException
     */
    public function getVetClinicById($clinicID) {
        $query = sprintf("SELECT $this->columnNames FROM `veterinarianclinic` "
                . "WHERE VeterinarianId='%s'", addslashes($clinicID));
        $result = DatabaseFactory::getOnePetOneVetDB()->mysql->query($query);
        if ($result->num_rows == 1) {
            return $this->convertRow($result->fetch_assoc());
        } else {
            throw new RuntimeException("Veterinarian clinic not found");
        }
    }

    /**
     * 
     * @param type $clinicName
     * @return type
     * @throws RuntimeException
     */
    public function findVeterinarianClinicByName($clinicName) {
        $query = sprintf("SELECT $this->columnNames FROM `veterinarianclinic` WHERE ClinicName like '%s%s%s'", "%", addslashes($clinicName), "%");
        $result = DatabaseFactory::getOnePetOneVetDB()->mysql->query($query);
        $clinic = $this->convertResults($result);
        if (count($clinic) < 1) {
            throw new RuntimeException("No Vet Clinic With That Name");
        }
        return $clinic;
    }
    public function findPendingVeterinarianClinicByName($clinicName) {
        $query = sprintf("SELECT $this->columnNames FROM `pendingclinic` WHERE ClinicName like '%s%s%s'", "%", addslashes($clinicName), "%");
        $result = DatabaseFactory::getOnePetOneVetDB()->mysql->query($query);
        $clinic = $this->convertResults($result);
        if (count($clinic) < 1) {
            throw new RuntimeException("No Vet Clinic With That Name");
        }
        return $clinic;
    }
    
    public function getVeterinarianClinicByName($clinicName) {
        $query = sprintf("SELECT $this->columnNames FROM `veterinarianclinic` WHERE ClinicName = '%s'", addslashes($clinicName));
        $result = DatabaseFactory::getOnePetOneVetDB()->mysql->query($query);
        $vets = $this->convertResults($result);
        if (count($vets) < 1) {
            throw new RuntimeException("No clinics With that name");
        }
        return $vets;
    }

    /**
     * 
     * @return type
     * @throws RuntimeException
     */
    public function getVeterinarianClinics() {
        $query = sprintf("SELECT $this->columnNames "
                . "FROM `veterinarianclinic`");
        $result = DatabaseFactory::getOnePetOneVetDB()->mysql->query($query);
        $veterinarianClinics = $this->convertResults($result);
        if (count($veterinarianClinics) < 1) {
            throw new RuntimeException("No Veterinarian Clinics found");
        }
        
        return $veterinarianClinics;
    }
    public function getPendingClinics() {
        $query = sprintf("SELECT $this->columnNames "
                . "FROM `pendingclinic`");
        $result = DatabaseFactory::getOnePetOneVetDB()->mysql->query($query);
        $veterinarianClinics = $this->convertResults($result);
        if (count($veterinarianClinics) < 1) {
            throw new RuntimeException("No pending Clinics found");
        }
        
        return $veterinarianClinics;
    }
    
    public function clinicValidationByZipAndName($name,$zip) {
        $letter = 's';
        $query = sprintf("SELECT ClinicName,Zipcode "
                . "FROM `veterinarianclinic` "
                . "where clinicname like '$letter%' and zipcode = '$zip' ");
        $result = DatabaseFactory::getOnePetOneVetDB()->mysql->query($query);
        $veterinarianClinics = $this->convertResults($result);
        if (count($veterinarianClinics) < 1) {
            throw new RuntimeException("No pending Clinics found");
        }
        
        return $veterinarianClinics;
    }
    
    public function clinicValidationByZip($zip) {
        
        $query = sprintf("SELECT $this->columnNames "
                . "FROM `veterinarianclinic` "
                . "where zipcode = '$zip' ");
        $result = DatabaseFactory::getOnePetOneVetDB()->mysql->query($query);
        $veterinarianClinics = $this->convertResults($result);
        
        
        return $veterinarianClinics;
    }
   
   
        
     

    protected function convertRow($row) {
        $veterinarianClinic = new VeterinarianClinic();
        $veterinarianClinic->mapRow($row);
        return $veterinarianClinic;
    }

    /**
     * 
     * @param type $vetstate
     * @param type $vetzip
     * @param type $vetcity
     * @return type
     * used for excel export of vet query
     */
    public function getVetQuery($vetstate, $vetzip, $vetcity) {
        $columnNames = "ClinicName,VeterinarianId,StreetAddress,State,City,Zipcode,PhoneNumber ";


        $query = "Select $columnNames from `veterinarianclinic` ";
        $multiple_entries = false;
        if ($vetstate !== "") {
            if ($multiple_entries == false) {
                $multiple_entries = true;
                $query .= "where state ='$vetstate' ";
            } else {
                $query .= "and state ='$vetstate' ";
            }
        }
        if ($vetcity !== "") {
            if ($multiple_entries == false) {
                $multiple_entries = true;
                $query .= "where city ='$vetcity' ";
            } else {
                $query .= "and city ='$vetcity' ";
            }
        }
        if ($vetzip !== "") {
            if ($multiple_entries == false) {
                $multiple_entries = true;
                $query .= "where zipcode =$vetzip ";
            } else {
                $query .= "and zipcode =$vetzip ";
            }
        }
        return $query;
    }
    
    
    
    public function confirmedEditOfClinicRow($a,$b,$c,$d,$e,$f,$g){
        $query = sprintf("UPDATE `veterinarianclinic` "
. "SET ClinicName='%s', StreetAddress='%s', State='%s',City='%s', Zipcode='%s', PhoneNumber='%s' "
. "WHERE VeterinarianId='%s'",addslashes($a),addslashes($b),addslashes($c),addslashes($d),addslashes($e),addslashes($f),addslashes($g));
           return DatabaseFactory::getOnePetOneVetDB()->mysql->query($query);

        }
    
     public function deleteClinicByID($clinicID) {
        $query = sprintf("DELETE FROM `veterinarianclinic` WHERE VeterinarianId='%s'", addslashes($clinicID));
        return DatabaseFactory::getOnePetOneVetDB()->mysql->query($query);
    }
    
    public function deletePendingByID($clinicID) {
        $query = sprintf("DELETE FROM `pendingclinic` WHERE VeterinarianId='%s'", addslashes($clinicID));
        return DatabaseFactory::getOnePetOneVetDB()->mysql->query($query);
    }
      public function addPendingClinic($a, $b, $c, $d, $e, $f) {
        $query = sprintf("INSERT INTO `veterinarianclinic` "
                . "(ClinicName,StreetAddress,State,City,Zipcode,PhoneNumber) "
                . "VALUES ('%s','%s','%s','%s','%s','%s')", addslashes($a), addslashes($b), addslashes($c), addslashes($d), addslashes($e), addslashes($f));
        return DatabaseFactory::getOnePetOneVetDB()->mysql->query($query);
    }
      public function userToPending($a, $b, $c, $d, $e, $f) {
        $query = sprintf("INSERT INTO `pendingclinic` "
                . "(ClinicName,StreetAddress,State,City,Zipcode,PhoneNumber) "
                . "VALUES ('%s','%s','%s','%s','%s','%s')", addslashes($a), addslashes($b), addslashes($c), addslashes($d), addslashes($e), addslashes($f));
        return DatabaseFactory::getOnePetOneVetDB()->mysql->query($query);
    }
    
    


}
