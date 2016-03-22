var map;
var idInfoBoxAberto;
var infoBox = [];

function initialize()
{
    var latlng = new google.maps.LatLng(-20.757503, -42.874956);

    var options = {
        zoom: 17,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    map = new google.maps.Map(document.getElementById("mapa"), options);
}
initialize();


function carregarPontos() {

    $.ajax({
        dataType: "json",
        type: 'POST',
        url: 'empresa/loadpoints',
        success: function(response) {

            $.each(response, function(index, empresa) {
                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(empresa.endereco.latitude, empresa.endereco.longitude),
                    title: empresa.nomefantasia,
                    map: map,
                    //icon: '/bundles/ufvdriconvenio/image/maker/'+ponto.paisid.nomept+'.png'
                });
            });


            /*
            $.each(response, function(index, universidadeid) {
                $.each(universidadeid, function(index, universidade) {
                    var ponto = universidade[0];
                    var marker = new google.maps.Marker({
                        position: new google.maps.LatLng(ponto.latitude, ponto.longitude),
                        title: ponto.nome,
                        map: map,
                        icon: '/bundles/ufvdriconvenio/image/maker/'+ponto.paisid.nomept+'.png'
                    });



                    var myOptions = {
                        content: "<p>"+ponto.nome + ' - ' + ponto.site +"</p>",
                        pixelOffset: new google.maps.Size(-150, 0)
                    };

                    infoBox[ponto.id] = new InfoBox(myOptions);
                    infoBox[ponto.id].marker = marker;

                    infoBox[ponto.id].listener = google.maps.event.addListener(marker, 'click', function (e) {
                        abrirInfoBox(ponto.id, marker);
                    });
                });
            });
            */
        }
    });
}
carregarPontos();