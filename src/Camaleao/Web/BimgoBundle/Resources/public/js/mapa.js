var map;
var idInfoBoxAberto;
var infoBox = [];

function initialize()
{
    var latlng = new google.maps.LatLng(-20.757503, -42.874956);

    var options = {
        zoom: 14,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    map = new google.maps.Map(document.getElementById("mapa"), options);
}
initialize();