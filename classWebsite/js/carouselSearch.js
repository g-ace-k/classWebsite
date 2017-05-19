$(document).ready(function () {
    function stopVideo(vid) {
        var iframe = document.getElementById(vid);
        if (iframe != null)
            iframe.src = "";
    }
    function startVideo(currentIndex) {
        var vid = "vid" + currentIndex;
        var iframe = document.getElementById(vid);
        console.log(iframe);
        if (iframe != null)
            iframe.src = iframe.name;
    }

    $(document).on('click','.switch',function (e) {
        e.preventDefault();
        e.stopPropagation();
        $.ajax({
            url: "ajax/getCarouselIndex.php",
            dataType: "json",
            method: "POST",
            data: {
                key: $(this).attr('data-key')
            },
            success: function (data) {
                
                var key = data;
                var currentItem = $("#carousel .item.active");
                var currentIndex = $('#carousel .item').index(currentItem);
                if (key != currentIndex) {
                    var vid = "vid" + currentIndex;
                    if (key.localeCompare("next") == 0) {
                        var indexMax = $("#carousel .item").size();
                        key = currentIndex + 1;
                        if (key >= indexMax)
                            key = 0;
                    }
                    else if (key.localeCompare("prev") == 0) {
                        var indexMax = $("#carousel .item").size();
                        key = currentIndex - 1;
                        if (key < 0)
                            key = indexMax - 1;
                    }
                    startVideo(key);
                    setTimeout(function () {
                        stopVideo(vid);
                    }, 400);
                }
            },
        });
    });
    
    $(document).on('click','.action',function (e) {
        $("#levelSelect").dropdown("toggle");
        e.preventDefault();
        e.stopPropagation();
        $.ajax({
            url: "ajax/findVideosByLevel.php",
            dataType: "json",
            method: "POST",
            data: {
                level: $(this).attr('data-level')
            },
            success: function (data) {
                var videos = data;
                var videoList = "";
                var carousel = "";
                var first = true;
                for (var i = 0; i < videos.length; i++) {
                    if (videos[i].hidden == 0) {
                        var vid = "vid" + i;
                        videoList += "<li><a href='#' class='switch' data-key="+i+" data-videoId=" + videos[i].videoId + " data-target='#carousel' data-slide-to=" + i + ">" + videos[i].name + "</a></li>";
                        if (first == false) {
                            carousel += "<div class='item' align='center'><iframe name=" + videos[i].videoLink + " id=" +vid+" width='100%' height='540' src='' frameborder='0' allowfullscreen></iframe><div style='color: black' align='center'><h1>" + videos[i].name + "</h1><p>" + videos[i].notes + "</p></div></div>"
                        }
                        else {
                            first = false;
                            carousel += "<div class='item active' align='center'><iframe name=" + videos[i].videoLink + " id=" +vid+" width='100%' height='540' src=" + videos[i].videoLink + " frameborder='0' allowfullscreen></iframe><div style='color: black' align='center'><h1>" + videos[i].name + "</h1><p>" + videos[i].notes + "</p></div></div>"
                        }
                    }
                }
                $('#levelSelect').html('Level ' + videos[0].tierLevel + ' Videos <span class="caret"></span>');
                $('#videos').html(videoList);
                $('#videoCarousel').html(carousel);
            }, //end of success
            error: function () {
                console.log("Error");
            }
        }); //end of ajax
    }); //end of on click

    $(document).on('click','.dogSelect',function (e) {
        $("#levelSelect").dropdown("toggle");
        e.preventDefault();
        e.stopPropagation();
        $.ajax({
            url: "ajax/findDogByDogId.php",
            dataType: "json",
            method: "POST",
            data: {
                dogId: $(this).attr('data-dogNumber')
            },
            success: function (data) {
                
                var dog = data;

                $('#dropdownDog').html(dog.dogName + " <span class='caret'></span>");
                $('#level').text('Level: ' + dog.level);
                $('#TTL').text(dog.targetTrainingLevel);
                
                $.ajax({
                   
                   url: "ajax/findHighestTier.php",
                   dataType: "json",
                   method: "POST",
                   success: function(data2) {
                       var tier=data2;
                       var dogVideos="";
                       for(var i=1; i<=tier;i++) {
                           if(dog.level<i) {
                               dogVideos+="<li class='disabled'><a>Level "+i+"</a></li>";
                           }
                           else {
                               dogVideos+="<li><a href='#' class='action' data-level='"+i+"'> Level " +i+ "</a></li>";
                           }
                       }
                       $('#dogsVideos').html(dogVideos);
                   }
                });
            }//end of success
        }); //end of ajax
    }); //end of on click
});


