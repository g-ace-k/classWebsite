<?php

/**
 * The vaccination data of a dog will be passed from database to this class
 *
 * @author Michael Gacek 2/19/16
 */
class VaccRecord implements JsonSerializable {

    private $rabies;
    private $parvovirus;
    private $distemper;
    private $hepatitis;
    private $measles;
    private $cav2;
    private $parainfluenza;
    private $bordetella;
    private $leptospirosis;
    private $coronavirus;
    private $lyme;
    private $vaccID;

    public function __get($name) {
        switch ($name) {
            case "rabies": return $this->rabies;
            case "parvovirus": return $this->parvovirus;
            case "distemper": return $this->distemper;
            case "hepatitis": return $this->hepatitis;
            case "measles": return $this->measles;
            case "cav2": return $this->cav2;
            case "parainfluenza": return $this->parainfluenza;
            case "bordetella": return $this->bordetella;
            case "leptospirosis": return $this->leptospirosis;
            case "coronavirus": return $this->coronavirus;
            case "lyme": return $this->lyme;
            case "vaccID": return $this->vaccID;
        }

        throw new InvalidArgumentException("Cannot access " . $name);
    }

    public function __set($name, $value) {
        if ($name != 'vaccID') {
            $value = $value ? new DateTime($value) : 'NULL';
        }
        switch ($name) {
            case "rabies": $this->rabies = $value;
                break;
            case "parvovirus": $this->parvovirus = $value;
                break;
            case "distemper": $this->distemper = $value;
                break;
            case "hepatitis": $this->hepatitis = $value;
                break;
            case "measles": $this->measles = $value;
                break;
            case "cav2": $this->cav2 = $value;
                break;
            case "parainfluenza": $this->parainfluenza = $value;
                break;
            case "bordetella": $this->bordetella = $value;
                break;
            case "leptospirosis": $this->leptospirosis = $value;
                break;
            case "coronavirus": $this->coronavirus = $value;
                break;
            case "lyme": $this->lyme = $value;
                break;
            case "vaccID": $this->vaccID = $value;
                break;
            default: throw new InvalidArgumentException("Cannot access " . $name);
        }
    }

    public function mapRow($row) {
        /*
          $this->rabies = $row["Rabies"];
          $this->parvovirus = $row["Parvovirus"];
          $this->distemper = $row["Distemper"];
          $this->hepatitis = $row["Hepatitis"];
          $this->measles = $row["Measles"];
          $this->cav2 = $row["CAV2"];
          $this->parainfluenza = $row["Parainfluenza"];
          $this->bordetella = $row["Bordetella"];
          $this->leptospirosis = $row["Leptospirosis"];
          $this->coronavirus = $row["Coronavirus"];
          $this->lyme = $row["Lyme"];
          $this->vaccID = $row["VaccID"];
         */
        $this->__set("rabies", $row["Rabies"]);
        $this->__set("parvovirus", $row["Parvovirus"]);
        $this->__set("distemper", $row["Distemper"]);
        $this->__set("hepatitis", $row["Hepatitis"]);
        $this->__set("measles", $row["Measles"]);
        $this->__set("cav2", $row["CAV2"]);
        $this->__set("parainfluenza", $row["Parainfluenza"]);
        $this->__set("bordetella", $row["Bordetella"]);
        $this->__set("leptospirosis", $row["Leptospirosis"]);
        $this->__set("coronavirus", $row["Coronavirus"]);
        $this->__set("lyme", $row["Lyme"]);
        $this->vaccID = $row["VaccID"];
    }

    public function jsonSerialize() {
        return [
            "rabies" => $this->serializeDate($this->rabies),
            "parvovirus" => $this->serializeDate($this->parvovirus),
            "distemper" => $this->serializeDate($this->distemper),
            "hepatitis" => $this->serializeDate($this->hepatitis),
            "measles" => $this->serializeDate($this->measles),
            "cav2" => $this->serializeDate($this->cav2),
            "parainfluenza" => $this->serializeDate($this->parainfluenza),
            "bordetella" => $this->serializeDate($this->bordetella),
            "leptospirosis" => $this->serializeDate($this->leptospirosis),
            "coronavirus" => $this->serializeDate($this->coronavirus),
            "lyme" => $this->serializeDate($this->lyme),
            "vaccID" => $this->vaccID
        ];
    }

    public function serializeDate($date) {
        if ($date && is_a($date, 'DateTime')) {
            return $date->format('m/d/Y');
        } else {
            return NULL;
        }
    }

}
