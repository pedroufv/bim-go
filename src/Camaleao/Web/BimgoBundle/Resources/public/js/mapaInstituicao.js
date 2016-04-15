var map;
var idInfoBoxAberto;
var infoBox = [];
var pinImage = {bimgoDefault: '/bundles/camaleaowebbimgo/img/pin_bim-go_45x51.png'};

function initialize(instituicao)
{
    console.log(instituicao);
    var latlng = new google.maps.LatLng(instituicao.endereco.latitude, instituicao.endereco.longitude);

    var options = {
        zoom: 17,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    map = new google.maps.Map(document.getElementById("mapa"), options);

    // Redimenciona o mapa para 60% da tela
    var winHeightPorcent = $(window).height()*0.60;
    $("#mapa").height(winHeightPorcent);

    carregarInstituicao(instituicao);
}
 
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

function carregarInstituicao(instituicao) {
    var marker = new google.maps.Marker({
        position: new google.maps.LatLng(instituicao.endereco.latitude, instituicao.endereco.longitude),
        title: instituicao.nomefantasia,
        map: map,
        icon: pinImage.bimgoDefault
    });

    infoBox[instituicao.id] = new InfoBox(dadosInfoBox(instituicao.nomefantasia, instituicao.endereco.latitude, instituicao.endereco.longitude));
    infoBox[instituicao.id].marker = marker;

    infoBox[instituicao.id].listener = google.maps.event.addListener(marker, 'click', function (e) {
        abrirInfoBox(instituicao.id, marker);
    });
}