<?php

class Videos implements JsonSerializable {
    
    private $videoLink;
    private $tierLevel;
    private $hidden;
    private $notes;
    private $name;
    private $dateUploaded;
    private $videoId;
    
    public function __get($name){
        switch($name){
            case "videoLink": return $this->videoLink;
            case "tierLevel": return $this->tierLevel;
            case "hidden": return $this->hidden;
            case "notes": return $this->notes;
            case "name": return $this->name;
            case "dateUploaded": return $this->dateUploaded;
            case "videoId": return $this->videoId;
        }
        
        throw new InvalidArgumentException("Cannot access ".$name);
    }
    
    public function __set($name, $value) {
        switch($name){
            case "videoLink": $this->videoLink = $value; break;
            case "tierLevel": $this->tierLevel = $value; break;
            case "hidden": $this->hidden = $value; break;
            case "notes": $this->notes = $value; break;
            case "name": $this->name = $value; break;
            case "dateUploaded": $this->dateUploaded = $value; break;
            case "videoId": $this->videoId = $value; break;
            default:throw new InvalidArgumentException("Cannot access ".$name);
        }
    }
    
    public function mapRow($row){
        $this->videoLink = $row["VideoLink"];
        $this->tierLevel = $row["TierLevel"];
        $this->hidden = $row["Hidden"];
        $this->notes = $row["Notes"];
        $this->name = $row["Name"];
        $this->dateUploaded = $row["DateUploaded"];
        $this->videoId = $row["VideoId"];
    }
    
    public function jsonSerialize() {
        return [
            "videoLink" => $this->videoLink,
            "tierLevel" => $this->tierLevel,
            "hidden" => $this->hidden,
            "notes" => $this->notes,
            "name" => $this->name,
            "dateUploaded" => $this->dateUploaded,
            "videoId" => $this->videoId,
        ];
    }

}

