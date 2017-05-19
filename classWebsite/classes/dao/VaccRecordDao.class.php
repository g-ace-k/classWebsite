<?php

require_once(dirname(__FILE__) . "/../db/DatabaseFactory.class.php");
require_once(dirname(__FILE__) . "/../model/VaccRecord.class.php");
require_once(dirname(__FILE__) . "/../Singleton.class.php");
require_once(dirname(__FILE__) . "/BaseDao.class.php");

/**
 * This Dao is used for VaccRecord functions and relations
 * @author Michael Gacek 2/19/16
 */
class VaccRecordDao extends BaseDao {

    private $columnNames = "Rabies,Parvovirus,Distemper,Hepatitis,Measles,CAV2,Parainfluenza,Bordetella,Leptospirosis,Coronavirus,Lyme,VaccID ";

    public function getVaccRecordByDog($vaccId) {

        $query = sprintf("SELECT $this->columnNames "
                . "FROM `vacc_record` WHERE VaccID='%s'", addslashes($vaccId));
        $result = DatabaseFactory::getOnePetOneVetDB()->mysql->query($query);
        if ($result->num_rows == 1) {
            return $this->convertRow($result->fetch_assoc());
        } else {
            throw new RuntimeException("No Vaccination Record found");
        }
    }

    public function updateVaccRecordByVaccId($vaccId, $rabies, $parvovirus, $distemper, 
            $hepatitis, $measles, $cav2, $parainfluenza, $bordetella, $leptospirosis, $coronavirus, $lyme) {
        $query = sprintf("UPDATE `vacc_record` SET Rabies = %s, Parvovirus = %s, Distemper = %s, Hepatitis = %s, "
                . "Measles = %s, CAV2 = %s, Parainfluenza = %s, Bordetella = %s, Leptospirosis = %s, Coronavirus = %s, "
                . "Lyme = %s WHERE VaccID='%s'", $this->getDate($rabies), $this->getDate($parvovirus), $this->getDate($distemper), $this->getDate($hepatitis), 
                $this->getDate($measles), $this->getDate($cav2), $this->getDate($parainfluenza), $this->getDate($bordetella), $this->getDate($leptospirosis), 
                $this->getDate($coronavirus), $this->getDate($lyme), addslashes($vaccId));
        return DatabaseFactory::getOnePetOneVetDB()->mysql->query($query);
    }
    
    public function getDate($date){
        if($date == 'NULL'){
            return 'NULL';
        }
        else{
            if(is_a($date,'DateTime')){                
                return "'".addslashes($date->format('Y-m-d'))."'";
            }
        }
    }

    protected function convertRow($row) {
        $vaccRecord = new VaccRecord();
        $vaccRecord->mapRow($row);
        return $vaccRecord;
    }
}
