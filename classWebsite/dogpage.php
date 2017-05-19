<?php
require_once(dirname(__FILE__) . "/includes/CheckUserAuthenticated.inc.php");
require_once(dirname(__FILE__) . "/includes/CheckForDog.inc.php");
require_once(dirname(__FILE__) . "/classes/dao/DogDao.class.php");
require_once(dirname(__FILE__) . "/classes/dao/VideosDao.class.php");
?>
<!doctype html>
<html>
    <!--
    Mike 4/7/16
    --> 
    <head> 
        <?php
        require_once("/includes/Head.inc.php");
        ?>
        <script type="text/javascript" src="js/carouselSearch.js"></script>
        <meta charset="UTF-8">
        <title>Dog Page</title>
    </head>

    <body>
        <div class="container-fluid"><!-- full page container -->
            <?php
            require_once("includes/header.inc.php");
            if (isset($_POST['startTraing'])) {
                $loadDog = $_POST['startTraing'];
                $d = DogDao::Instance()->getDogByDogId($loadDog);
            }
            
            ?>
            <br>

            <div class="row dogbody">
                <div class="col-lg-2 col-lg-offset-1">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            
                            <?php
                                
                                echo "<div class='dropdown'>"
                                . "<button style='font-size: 32px; border-style: none;' id='dropdownDog' class='btn btn-default btn-block btn-lg dropdown-toggle ' type='button' data-toggle='dropdown'"; if(count($dogs<=1)){ echo "disabled='disabled'";} echo ">  $d->dogName ";
                                if (count($dogs) > 1) {
                                    echo"<span class='caret'></span>";
                                    
                                }
                                echo "</button><ul class='dropdown-menu'>";
                                foreach ($dogs as $key => $dg) {
                                    echo "<li><a href='#' class='action dogSelect' data-dogNumber='$dg->dogID' data-level='$dg->level'>" . ($dg->dogName) . "</a></li>";
                                }
                                echo "</ul>"
                                . "</div>";
                                ?>
                                
                                <p style=" border-top: 2px solid #ccc; " class="text-center" id="TTL"><?php print $d->targetTrainingLevel; ?></p>
                                <p class="text-center" id="level"> Level: <?php print $d->level; ?></p>
                                
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12 col-xs-4 col-xs-offset-4 col-lg-offset-0">
                            <ul class="nav nav-pills nav-stacked">
                                <li class="dropdown">
                                    <a id="levelSelect" class="btn btn-default btn-block btn-lg dropdown-toggle text-center" data-toggle="dropdown" href="#">Level <?php print($d->level); ?> Videos
                                        <span class="caret"></span></a>
                                    <ul id="dogsVideos" class="dropdown-menu">
                                        <?php
                                        $num = VideoDao::Instance()->getNumOfTiers();
                                        for ($i = 1; $i <= $num; $i++) {
                                            if ($d->level < $i)
                                                echo "<li class='disabled'><a>Level " . $i . "</a></li>";
                                            else
                                                echo "<li><a href='#' class='action' data-level='$i'> Level " . $i . "</a></li>";
                                        }
                                        ?>

                                    </ul>
                                </li>
                                <div id="videos">
                                    <?php
                                    $videos = VideoDao::Instance()->getNonHiddenVideosByTier($d->level);
                                    foreach ($videos as $key => $v) {    
                                        echo "<li ><a href='#' class='switch' data-key='$key' data-videoId='$v->videoId' data-target='#carousel' data-slide-to='$key'>" . $v->name . "</a></li>";
                                    }
                                    ?>
                                </div>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7 col-lg-offset-1">
                    <div class="row">
                        <div class="col-lg-12" >
                            <div id="carousel" class="carousel slide" data-interval="false">
                                <!-- Wrapper for slides -->
                                <div id="videoCarousel" class="carousel-inner" role="listbox">
                                    <?php
                                    $videos = VideoDao::Instance()->getNonHiddenVideosByTier($d->level);
                                    $first = true;
                                    foreach ($videos as $key => $v) {
                                        if ($v->hidden == 0) {
                                            if ($first == false) {
                                                echo "<div class='item' align='center'>"
                                                . "<iframe name='$v->videoLink' id='vid$key' width='100%' height='540' src='' frameborder='0' allowfullscreen></iframe><div style='color: black' align='center'><h1>$v->name</h1><p>$v->notes</p></div>"
                                                . "</div>";
                                            } else {
                                                $first = false;
                                                echo "<div class='item active' align='center'>"
                                                . "<iframe name='$v->videoLink' id='vid$key' width='100%' height='540' src='$v->videoLink' frameborder='0' allowfullscreen></iframe><div style='color: black' align='center'><h1>$v->name</h1><p>$v->notes</p></div>"
                                                . "</div>";
                                            }
                                        }
                                    }
                                    ?>

                                </div>
                                <a class="left carousel-control switch" style="margin-left: -55px;" href="#carousel" role="button" data-slide="prev" data-key="prev">
                                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="right carousel-control switch" style="margin-right: -55px;" href="#carousel" role="button" data-slide="next" data-key="next">
                                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        require_once("footer.php");
        ?>
    </div>
</body>
</html>
