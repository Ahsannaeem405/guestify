<?php
    if(!isset($width)) {
        $width = '300px';
    }
    if(!isset($height)) {
        $height = '300px';
    }
    if(!isset($zoom)) {
        $zoom = '10';
    }
    if(!isset($max_zoom)) {
        $max_zoom = '10';
    }
?>

    <style>
      #directions-panel {
        height: 100%;
        float: right;
        width: 100%;
        overflow: auto;
      }
      </style>

<?php if(isset($lat) && isset($lng) && !empty($lat) && !empty($lng)) { ?>
    <div class="clearfix">
        <div class="clearfix">
            <div id="map_canvas" style="width: <?php echo $width; ?>; height: <?php echo $height; ?>;"></div>
        </div>
    </div>

    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>

    <script>
        $(document).ready(function() {

            var lat = <?php echo json_encode($lat); ?>;
            var lng = <?php echo json_encode($lng); ?>;
            var zoom = <?php echo json_encode($zoom); ?>;

            var host = <?php echo json_encode($host); ?>;

            initialize(lat, lng, zoom, host);
        });


        function initialize(lat, lng, zoom, host) {

            // maybe add country center here for initial loading...
            var center = new google.maps.LatLng(lat, lng);
            var myOptions = {
                zoom: parseInt(zoom),
                //maxZoom: <?php echo $max_zoom; ?>,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                streetViewControl: true,
                scaleControl: true
            };


            var map = new google.maps.Map(document.getElementById('map_canvas'), myOptions);
            var bounds = new google.maps.LatLngBounds();


            // define the "bubble" when clicking the pin on the map => style as you like!
            var contentString = '' + 
                '<div style="width:200px; height:100px">'+
                    '<strong>'+host.Host.name+'</strong><br />' +
                    '<p>'+
                        host.Host.address + '<br />' + 
                        host.Host.zipcode + host.Host.city + '<br />' + 
                        host.Host.country_name + '<br />' + 
                        //'<a href="/'+$('#baseurl-offers').text()+'/'+offer.Meta.niceurl+'" class="btn btn-xs btn-success">' + $('#goto_offers_text').text() + '</a>' +
                    '</p>'+
                '</div>';

            // set the builded string into an infowindow object
            var infowindow = new google.maps.InfoWindow({
                content: contentString,
                maxWidth: 400
            });

            // set the geocoordinates object
            var latlng = new google.maps.LatLng(lat, lng);
            bounds.extend(latlng);

            // define the marker object and add it to the markers array
            var marker = new google.maps.Marker({
                position: latlng,
                animation: google.maps.Animation.DROP,
                title: 'Your location',
                map: map,
                //icon: image
            });

            // add the marker to the map
            google.maps.event.addListener(marker, 'click', function() {
                if(!infowindow.getMap()) {
                    infowindow.open(map, marker);
                } else {
                    infowindow.close();
                }
            });

            //map.fitBounds(bounds);
            map.setCenter(bounds.getCenter());

            /*
            // neat method to "correct" a zoom after bound-fitting
            var listener = google.maps.event.addListener(map, "idle", function() { 
                if (map.getZoom() > 16) map.setZoom(10); 
                google.maps.event.removeListener(listener); 
            });
            */

            return;

        }

    </script>

<?php } ?>
