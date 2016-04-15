var map;
var idInfoBoxAberto;
var infoBox = [];
var pinImage = {bimgoDefault: '/bundles/camaleaowebbimgo/img/pin_bim-go_45x51.png'};

function initialize()
{
    var latlng = new google.maps.LatLng(-20.7547815,-42.8789577);

    var options = {
        zoom: 14,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    map = new google.maps.Map(document.getElementById("mapa"), options);

    // Redimenciona o mapa para 60% da tela
    var winHeightPorcent = $(window).height()*0.60;
    $("#mapa").height(winHeightPorcent);

    carregarPontos();
}
initialize();
 
function abrirInfoBox(id, marker) {
    if (typeof(idInfoBoxAberto) == 'number' && typeof(infoBox[idInfoBoxAberto]) == 'object') {
        infoBox[idInfoBoxAberto].close();
    }
 
    infoBox[id].open(map, marker);
    idInfoBoxAberto = id;
}

function dadosInfoBox(nome,latitude,longitude){
    var divInfoBoxContent = '<p class="nome">'+nome+'<p>'
                            +'<p class="latitude">'+latitude+'<p>'
                            +'<p class="longitude">'+longitude+'<p>';
    var myOptions = {
        content: divInfoBoxContent,
        pixelOffset: new google.maps.Size(-150, 0)
    };

    return myOptions;
}

function carregarPontos() {

    $.ajax({
        dataType: "json",
        type: 'POST',
        url: '/instituicao/getmapadata',
        success: function(response) {

            $.each(response, function(index, empresa){
                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(empresa.latitude, empresa.longitude),
                    title: empresa.nomefantasia,
                    map: map,
                    icon: pinImage.bimgoDefault
                });
                     
                infoBox[index] = new InfoBox(dadosInfoBox(empresa.nomefantasia,empresa.latitude,empresa.longitude));
                infoBox[index].marker = marker;
             
                infoBox[index].listener = google.maps.event.addListener(marker, 'click', function (e) {
                    abrirInfoBox(index, marker);
                });
            });
        }
        
    });
}