<?php

require_once(dirname(__FILE__) . "/../db/DatabaseFactory.class.php");
require_once(dirname(__FILE__) . "/../model/Videos.class.php");
require_once(dirname(__FILE__) . "/../Singleton.class.php");
require_once(dirname(__FILE__) . "/BaseDao.class.php");
require_once(dirname(__FILE__) . "/../exceptions/InvalidInputException.class.php");

class VideoDao extends BaseDao {

    private $columnNames = "VideoLink,TierLevel,Hidden,Notes,Name,DateUploaded,VideoId ";

    public function getVideosByTier($tierLevel) {
        $query = sprintf("SELECT $this->columnNames "
                . "FROM `videos` WHERE tierLevel='%s'", addslashes($tierLevel));
        $result = DatabaseFactory::getOnePetOneVetDB()->mysql->query($query);
        $videos = $this->convertResults($result);
        if (count($videos) < 1) {
            throw new RuntimeException("No videos found");
        }
        return $videos;
    }
    
    public function getNonHiddenVideosByTier($tierLevel) {
        $maxTier = $this->getNumOfTiers();
        if ($maxTier < $tierLevel)
            $tierLevel = $maxTier;
        $query = sprintf("SELECT $this->columnNames "
                . "FROM `videos` WHERE tierLevel='%s' AND hidden=0", addslashes($tierLevel));
        $result = DatabaseFactory::getOnePetOneVetDB()->mysql->query($query);
        $videos = $this->convertResults($result);
        if (count($videos) < 1) {
            throw new RuntimeException("No videos found");
        }
        return $videos;
    }

    public function getNumOfTiers() {
        $query = sprintf("SELECT $this->columnNames "
                . "FROM `videos` WHERE hidden='0' ORDER BY tierLevel DESC LIMIT 1");
        $result=DatabaseFactory::getOnePetOneVetDB()->mysql->query($query);
        $row = $this->convertRow($result->fetch_assoc());
        return $row->tierLevel;
    }

    public function getVideoById($videoId) {
        $query = sprintf("SELECT $this->columnNames "
                . "FROM `videos` WHERE videoId='%s'", addslashes($videoId));
        $result = DatabaseFactory::getOnePetOneVetDB()->mysql->query($query);
        if ($result->num_rows == 1) {
            return $this->convertRow($result->fetch_assoc());
        } else {
            throw new RuntimeException("Video not found");
        }
    }

    public function getVideoByName($videoName) {
        $query = sprintf("SELECT $this->columnNames FROM `videos` WHERE Name = '%s'", addslashes($videoName));
        $result = DatabaseFactory::getOnePetOneVetDB()->mysql->query($query);
        $video = $this->convertResults($result);
        if (count($video) < 1) {
            throw new RuntimeException("No Module With That Name");
        }
        return $video;
    }
    /**
     * 
     * @param type $url
     * @return type
     */
    private function parseYTurl($url) {
        $pattern = '#^(?:https?://)?(?:www\.|m\.)?(?:youtu\.be/|youtube\.com(?:/embed/|/v/|/watch\?v=|/watch\?.+&v=))([\w-]{11})(?:.+)?$#x';
        preg_match($pattern, $url, $matches);
        return isset($matches[1]) ? $matches[1] : false;
    }
    /**
     * 
     * @param type $url
     * @return type
     */
    private function parseVimeo($url)
    {
        $pattern = '/https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\?)/';

        preg_match($pattern, $url, $matches);
        return isset($matches[3]) ? $matches[3] : false;
    }
    /**
     * 
     * @param type $videoLink
     * @param type $tierLevel
     * @param type $hidden
     * @param type $notes
     * @param type $name
     * @return type
     */
    public function addVideo($videoLink, $tierLevel, $hidden, $notes, $name) {
        $url = $this->parseYTurl($videoLink);
        if($url!=false) {
            $videoLink = "https://youtube.com/embed/" . $url ."?controls=0&showinfo=0&rel=0&modestbranding=1";
        }
        else {
            $url=$this->parseVimeo($videoLink);
            if($url!=false) {
                $videoLink="https://player.vimeo.com/video/".$url;
            }
            else {
                throw new InvalidArgumentException("Module URL is invalid");
            }
        }
        $query = sprintf("INSERT INTO `videos` (VideoLink, TierLevel,Hidden,Notes,Name) "
                . "VALUES ('%s','%s','%s','%s','%s')", addslashes($videoLink), addslashes($tierLevel), addslashes($hidden), addslashes($notes), addslashes($name));
        return DatabaseFactory::getOnePetOneVetDB()->mysql->query($query);
    }
    /**
     * 
     * @param type $videoId
     * @return type
     */
    public function deleteModuleById($videoId) {
        $query = sprintf("DELETE FROM `videos` WHERE videoId='%s'", addslashes($videoId));
        return DatabaseFactory::getOnePetOneVetDB()->mysql->query($query);
    }
    /**
     * 
     * @param string $videoLink
     * @param type $tierLevel
     * @param type $hidden
     * @param type $notes
     * @param type $name
     */
    public function updateModule($videoLink, $tierLevel, $hidden, $notes, $name, $videoId)
    {
        $url = $this->parseYTurl($videoLink);
        if($url!=false) {
            $videoLink = "https://youtube.com/embed/" . $url ."?autoplay=0&controls=0&showinfo=0&rel=0&modestbranding=1";
        }
        else {
            $url=$this->parseVimeo($videoLink);
            if($url!=false) {
                $videoLink="https://player.vimeo.com/video/".$url;
            }
            else {
                throw new InvalidArgumentException("Module URL is invalid");
            }
        }
        $query = sprintf("UPDATE `videos` SET VideoLink = '%s',TierLevel = '%s',Hidden = '%s',Notes = '%s',Name = '%s' WHERE VideoId='%s'" ,  addslashes($videoLink),addslashes($tierLevel),addslashes($hidden),addslashes($notes),addslashes($name),addslashes($videoId));
        return DatabaseFactory::getOnePetOneVetDB()->mysql->query($query);
    }

    protected function convertRow($row) {
        $video = new Videos();
        $video->mapRow($row);
        return $video;
    }

}
