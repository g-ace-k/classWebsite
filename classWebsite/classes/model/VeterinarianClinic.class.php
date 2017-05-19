<?php
/**
 * Pulls data from database into veterinarian clinic class
 * @author Michael Gacek 2/19/16
 */
class VeterinarianClinic implements JsonSerializable{
    
    private $clinicName;
    private $veterinarianId;
    private $streetAddress;
    private $state;
    private $city;
    private $zipcode;
    private $phoneNumber;
            
    public function __get($name){
        switch($name){
            case "clinicName": return $this->clinicName;
            case "veterinarianId": return $this->veterinarianId;
            case "streetAddress": return $this->streetAddress;
            case "state": return $this->state;
            case "city": return $this->city;
            case "zipcode": return $this->zipcode;
            case "phoneNumber": return $this->phoneNumber;
        }
        
        throw new InvalidArgumentException("Cannot access ".$name);
    }
    
    public function __set($name, $value) {
        switch($name){
            case "clinicName": $this->clinicName = $value; break;
            case "veterinarianId": $this->veterinarianId = $value; break;
            case "streetAddress": $this->streetAddress = $value; break;
            case "state": $this->state = $value; break;
            case "city": $this->city = $value; break;
            case "zipcode": $this->zipcode = $value; break;
            case "phoneNumber": $this->phoneNumber = $value; break;          
        }
        
        throw new InvalidArgumentException("Cannot access ".$name);
    }
    
    public function mapRow($row){
        $this->clinicName = $row["ClinicName"];
        $this->veterinarianId = $row["VeterinarianId"];
        $this->streetAddress = $row["StreetAddress"];
        $this->state = $row["State"];
        $this->city = $row["City"];
        $this->zipcode = $row["Zipcode"];
        $this->phoneNumber = $row["PhoneNumber"];
    }
    
    public function jsonSerialize() {
        return [
            "clinicName" => $this->clinicName,
            "veterinarianId" => $this->veterinarianId,
            "streetAddress" => $this->streetAddress,
            "state" => $this->state,
            "city" => $this->city,
            "zipcode" => $this->zipcode,
            "phoneNumber" => $this->phoneNumber,
        ];
    }
}
