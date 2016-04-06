// Visualizar no public
// app/console assets:install --symlink --relative




var map;
var idInfoBoxAberto;
var infoBox = [];
var pinImage = {
        bimgoDefault: 'bundles/camaleaowebbimgo/img/pin_bim-go_45x51.png'
    };


var empresas = [ // Utilizando esse Objeto como exemplo ate que a url entregue as empresas
    {
        nomefantasia: 'Prefeitura',
        endereco: {
            latitude: -20.7548099,
            longitude: -42.8790035
        }
    },
    {
        nomefantasia: 'Casa do Cleverson',
        endereco: {
            latitude: -20.7562232,
            longitude: -42.8854347
        }
    },
    {
        nomefantasia: 'Casa do Diego',
        endereco: {
            latitude: -20.7500267,
            longitude: -42.8842513
        }
    },
    {
        nomefantasia: 'Casa do Rhuan',
        endereco: {
            latitude: -20.7549866,
            longitude: -42.8803364
        }
    },    
    {
        nomefantasia: 'Casa do Pedro',
        endereco: {
            latitude: -20.7683248,
            longitude: -42.8883133
        }
    },
];


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
        url: 'empresa/loadpoints',
        success: function(response) {

            // ATENÇÂO:
            // No $.each, troque 'empresas' por 'response' quando a url: 'empresa/loadpoints' entregar as empresas
            // Em seguida apague estes comentarios;

            $.each(response, function(index, empresa){
                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(empresa.endereco.latitude, empresa.endereco.longitude),
                    title: empresa.nomefantasia,
                    map: map,
                    //icon: '/bundles/ufvdriconvenio/image/maker/'+ponto.paisid.nomept+'.png'
                    icon: pinImage.bimgoDefault
                });
                //console.log("Empresa: %s \nLatitude: %s \nLongitude: %s", empresa.nomefantasia,empresa.endereco.latitude, empresa.endereco.longitude);
                     
                infoBox[index] = new InfoBox(dadosInfoBox(empresa.nomefantasia,empresa.endereco.latitude,empresa.endereco.longitude));
                infoBox[index].marker = marker;
             
                infoBox[index].listener = google.maps.event.addListener(marker, 'click', function (e) {
                    abrirInfoBox(index, marker);
                });
            });
        }
        
    });
}