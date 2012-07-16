// By Nick Tetcu
(function() {
  window.onload = function() {

    var options = {
      zoom: 15,
      center: new google.maps.LatLng(43.6142563, -79.51731540000003),
      noClear: true,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map(document.getElementById('map'), options);
    var home_shadow = new google.maps.MarkerImage(
      'http://survey.cjskateboardcamp.com/wp-content/uploads/2012/06/cjsk8-map-marker_shadow.png',
      null,
      null,
      new google.maps.Point(-1, 43)
    );
    var home_marker = new google.maps.Marker({
      position: new google.maps.LatLng(43.6142563, -79.51731540000003),
      map: map,
      title: "You've just reached the King castle ...",
      icon: 'http://survey.cjskateboardcamp.com/wp-content/uploads/2012/06/cjsk8-map-marker.png',
      shadow: home_shadow
    });
    var info_content = '<div class="info-content"><h2>C.J. Skateboard Park & School</h2>';
    info_content += '<img src="http://survey.cjskateboardcamp.com/wp-content/uploads/2012/06/frontesk.jpg" alt="CJ Skateboard Park & School" width="140" height="94">';
    info_content += '<p class="r-txt red">60 Horner Avenue<br />Etobicoke, ON M8Z 4X3</p>';
    info_content += '<p class="r-txt">Tel: 416.259.6888 ext.233<br />Fax: 416.588.8181<br />E-mail: <a href="mailto:nick@cjdigital.ca">nick@cjdigital.ca</a></div>';
    var infowindow = new google.maps.InfoWindow({
      content: info_content
    });

    google.maps.event.addListener(home_marker, 'click', function() {
      toggleBounce();
      infowindow.open(map, home_marker);
    });

    function toggleBounce() {
      if (home_marker.getAnimation() != null) {
        home_marker.setAnimation(null);
      } else {
        home_marker.setAnimation(google.maps.Animation.BOUNCE);
      }
    }

  };
})();