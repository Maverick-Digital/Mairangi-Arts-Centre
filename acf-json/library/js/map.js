
    function initMap() {
       
      var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat:-38.156955, lng: 176.2707513}, 
          zoom: 15,
           tilt: 45,
   		 rotateControl: true,
        //styles: [{"featureType":"water","elementType":"geometry","stylers":[{"color":"#e9e9e9"},{"lightness":17}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#ffffff"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":16}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":21}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#dedede"},{"lightness":21}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"lightness":16}]},{"elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#333333"},{"lightness":40}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#f2f2f2"},{"lightness":19}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#fefefe"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#fefefe"},{"lightness":17},{"weight":1.2}]}]

        });

        var infowindow = new google.maps.InfoWindow();
        var service = new google.maps.places.PlacesService(map);
        var host = window.location.host;
        console.log(window.location.host );
        if(host == "localhost:8888"){
        	host = "localhost:8888/redwoodstreewalk";
        }
var imagePath = window.location.protocol + "//" + host + "/wp-content/themes/treewalk/library/images/map_marker.svg";
console.log(imagePath);
var image = {

        	url: imagePath ,
        labelOrigin: new google.maps.Point(20,70),
       
    }
    

        service.getDetails({
          placeId: 'ChIJRTtx5-udbm0RE3nN2R3v1V0'
        }, function(place, status) {
          if (status === google.maps.places.PlacesServiceStatus.OK) {
            var marker = new google.maps.Marker({
              map: map,
              icon: image,
               
              animation: google.maps.Animation.DROP,
              position: place.geometry.location,
              /* label: {
    color: '#c02e25',
    fontWeight: 'bold',
    
   // text: place.name,
  }, */
  
      labelAnchor: new google.maps.Point(20, 0),

  
            });
            google.maps.event.addListener(marker, 'click', function() {
              infowindow.setContent('<div><strong>' + place.name + '</strong><br>' +
              
                place.formatted_address + '</div>');
              infowindow.open(map, this);
            });
          }
        });
      }

/*
	//Resize Function
		google.maps.event.addDomListener(window, "resize", function() {
			var center = map.getCenter();
			google.maps.event.trigger(map, "resize");
			map.setCenter(center);
		});
	
	}

*/