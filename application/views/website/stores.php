<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- ========================= SECTION PRODUCTOVIEW ========================= -->
<section class="section-content bg padding-y-sm dipe-section-content">
    <div class="container">
        <div class="card">
            <div class="row no-gutters">
                <div id="dvMap" class="map-responsive" ></div>
            </div> <!-- row.// -->
        </div> <!-- card.// -->
    </div> <!-- container .//  -->
</section>
<!-- ========================= SECTION PRODUCTOVIEW END// ========================= -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAIl9_rJ3hhYX1F0nv0n_7eCT27iju-0T4&libraries=places,geometry&sensor=false"></script>
<script type="text/javascript">

    $.ajax({
        type: "get",
        async: true,
        url: '<?php echo base_url('api_stores_all')?>',
        success: function(data) {

            if(data['result']=='1')
            {
                var stores = data['data'];
                console.log(data['data']);

                var markers = data['data'];

                inputTextVal = "";
                infowindows = [];

                map = new google.maps.Map(document.getElementById('dvMap'), {
                    disableDefaultUI: true,
                    zoom: 10,
                    gestureHandling: 'greedy',
                    fullscreenControl: false,
                    mapTypeControlOptions: {
                        style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
                    },
                    styles: [
                        {
                            "featureType": "poi",
                            "stylers": [
                                { "visibility": "off" }
                            ]
                        },
                        {
                            "featureType": "transit.station",
                            "stylers": [
                                { "visibility": "off" }
                            ]
                        },
                        {
                            "featureType": "administrative",
                            "stylers": [
                                { "visibility": "off" }
                            ]
                        },
                        {
                            "featureType": "landscape.man_made",
                            "stylers": [
                                { "visibility": "off" }
                            ]
                        }
                    ]

                });
                var infoWindow = new google.maps.InfoWindow();
                infowindows.push(infoWindow);
                var latlngbounds = new google.maps.LatLngBounds();


                var options = {
                    bounds: google.maps.LatLngBounds( google.maps.LatLng(33.1613, -118.4766), google.maps.LatLng(14.3770, -84.8145) )
                };


                //--------
                for (var i = 0; i < markers.length; i++) {
                    var data = markers[i]
                    var myLatlng = new google.maps.LatLng(data.lat, data.lng);


                    if(data.activate=='1')
                    {
                        var marker = new google.maps.Marker({
                            position: myLatlng,
                            map: map,
                            store_name: data.store_name,
                            icon: "my-assets/image/dipe-marker_icon.png"
                        });
                    }
                    else
                    {
                        var marker = new google.maps.Marker({
                            position: myLatlng,
                            map: map,
                            store_name: data.store_name,
                            icon: "my-assets/image/dipe-marker_icon_inactive.png"
                        });
                    }

                    (function (marker, data) {
                        google.maps.event.addListener(marker, "click", function (e) {
                            map.setZoom(14);
                            map.panTo(marker.position);
                            infoWindow.setContent("<div style = 'width:200px;min-height:40px'>" + data.store_name + ". " + data.store_address + "<div class = ''></div></div>");
                            infoWindow.open(map, marker);

                        });
                    })(marker, data);
                    latlngbounds.extend(marker.position);
                }
                var bounds = new google.maps.LatLngBounds();
                map.setCenter(latlngbounds.getCenter());

                (function ($) {
                    $.each(['show', 'hide'], function (i, ev) {
                        var el = $.fn[ev];
                        $.fn[ev] = function () {
                            this.trigger(ev);
                            return el.apply(this, arguments);
                        };
                    });
                })(jQuery);

            }
            else
            {
                alert('API no disponible!');
            }
        },
        error: function() {
            alert('Error al cargar lo mapas, por favor recargue la página web, gracias!');
        }
    });



    /*var markers = [
        {
            "store_name": 'SUC CENTRO HIDALGO',
            "lat": '18.14356',
            "lng": '-94.42881',
            "store_address": 'AV. MIGUEL HIDALGO N° 1110 COL. CENTRO C.P. 96400 COATZACOALCOS VER.'
        },
        {
            "store_name": 'SUC CENTRAL DE ABASTOS',
            "lat": '17.99553',
            "lng": '-94.57271',
            "store_address": 'LOCAL 113 Y 114 B CENTRAL DE ABASTOS COL. ROSALINDA C.P. 96710 MINATITLAN VER.'
        },
        {
            "store_name": 'SUC PLAYON SUR',
            "lat": '17.97986',
            "lng": '-94.54475',
            "store_address": 'XICOTENCATL N° 6 COL. PLAYON SUR C.P. 96700 MINATITLAN VER'
        },
        {
            "store_name": 'SUC LAS CHOAPAS',
            "lat": '17.9126',
            "lng": '-94.09255',
            "store_address": 'BLVD. ANTONIO M. QUIRAZCO N° 103 COL. CAMPO NUEVO C.P. 96980 LAS CHOAPAS VER.'
        },
        {
            "store_name": 'SUC CENTRO JUAREZ',
            "lat": '18.14701',
            "lng": '-94.41141',
            "store_address": 'AV. BENITO JUAREZ N° 100 C.P. 96400 COL. CENTRO COATZACOALCOS VER.'
        },
        {
            "store_name": 'SUC AGUA DULCE',
            "lat": '18.1442',
            "lng": '-94.14156',
            "store_address": 'AV. FERROCARRIL N°1 COL. CENTRO C.P. 96600 AGUA DULCE VER.'
        },
        {
            "store_name": 'SUC LA SABANA',
            "lat": '17.89104',
            "lng": '-94.10414',
            "store_address": '20 DE NOVIEMBRE N° 1265 COL. LA SABANA C.P. 96980 LAS CHOAPAS VER.'
        },
        {
            "store_name": 'SUC LERDO',
            "lat": '17.98408',
            "lng": '-94.54521',
            "store_address": 'AV. LERDO N° 44 COL. CENTRO C.P. 96700 MINATITLAN VER.'
        },
        {
            "store_name": 'SUC DULCERIA',
            "lat": '18.14681',
            "lng": '-94.41395',
            "store_address": 'JOSE MARIA MORELOS N° 305 COL. CENTRO C.P. 96400 COATZACOALCOS VER.'
        },
        {
            "store_name": 'SUC GAVIOTAS',
            "lat": '18.13755',
            "lng": '-94.50307',
            "store_address": 'AV. UNIVERSIDAD VERACRUZANA S/N KM. 10 COL. LAS GAVIOTAS C.P. 96536 COATZACOALCOS VER.'
        },
        {
            "store_name": 'SUC ALLENDE 1',
            "lat": '18.15442',
            "lng": '-94.37938',
            "store_address": 'GUTIERREZ ZAMORA N°2800 COL. EJIDAL C.P. 96380 VILLA ALLENDE COATZACOALCOS VER.'
        },
        {
            "store_name": 'SUC PALMITAS',
            "lat": '18.13925',
            "lng": '-94.46186',
            "store_address": 'MARCOS HEREDIA N° 712 COL. 20 DE NOVIEMBRE C.P. 96570 COATZACOALCOS VER.'
        },
        {
            "store_name": 'SUC ACAYUCAN',
            "lat": '17.9493',
            "lng": '-94.90712',
            "store_address": 'MIGUEL HIDALGO N° 204 COL. ZAPOTAL C.P. 96039 ACAYUCAN VER.'
        },
        {
            "store_name": 'SUC EXPRESS MALPICA',
            "lat": '18.14209',
            "lng": '-94.42946',
            "store_address": 'HILARIO RODRIGUEZ MALPICA N° 1129 COL. MANUEL AVILA CAMACHO C.P. 96420 COATZACOALCOS VER.'
        },
        {
            "store_name": 'SUC OLMECA',
            "lat": '18.15207',
            "lng": '-94.55239',
            "store_address": 'BOULEVARD A BARRILLAS N° 104 COL. CIUDAD OLMECA C.P. 96535 COATZACOALCOS VER.'
        },
        {
            "store_name": 'SUC FCO. VILLA',
            "lat": '18.12376',
            "lng": '-94.45843',
            "store_address": 'BLVD. JUAN OSORIO LOPEZ N° 214 COL. FCO VILLA C.P. 96566 COATZACOALCOS VER.'
        },
        {
            "store_name": 'SUC NANCHITAL',
            "lat": '18.07022',
            "lng": '-94.4063',
            "store_address": 'AV. REVOLUCION N° 51 ESQ LAZARO CARDENAS COL. OBRERA C.P. 96360 NANCHITAL VER.'
        },
        {
            "store_name": 'SUC ALLENDE II',
            "lat": '18.15056',
            "lng": '-94.40463',
            "store_address": 'GUTIERREZ ZAMORA N° 306 ESQ ADOLFO LOPEZ MATEOS COL. CENTRO C.P. 96380 VILLA ALLENDE COATZACOALCOS VER.'
        },
        {
            "store_name": 'SUC EMILIANO ZAPATA',
            "lat": '18.13409',
            "lng": '-94.44813',
            "store_address": 'EMILIANO ZAPATA N° 1310 COL. BENITO JUAREZ NORTE C.P. 96576 COATZACOALCOS VER.'
        },
        {
            "store_name": 'SUC JALTIPAN',
            "lat": '17.96554',
            "lng": '-94.72007',
            "store_address": 'MORELOS N° 117 COL. CENTRO C.P. 96200 JALTIPAN VER.'
        },
        {
            "store_name": 'SUC OTEAPAN',
            "lat": '17.99562',
            "lng": '-94.66161',
            "store_address": 'PINO SUEREZ N° 207 COL. LA CRUZ C.P. 96330 OTEAPAN VER.'
        },
        {
            "store_name": 'SUC TRANSPORTISTAS',
            "lat": '18.13634',
            "lng": '-94.49048',
            "store_address": 'QUETZALCOATL N° 123 COL. TRANSPORTISTAS COATZACOALCOS VER.'
        },
        {
            "store_name": 'SUC QUEVEDO',
            "lat": '18.14823',
            "lng": '-94.44039',
            "store_address": 'QUEVEDO N° 1711 COL. PUERTO MEXICO C.P. 96510 COATZACOALCOS VER.'
        },
        {
            "store_name": 'CADI',
            "lat": '18.14417',
            "lng": '-94.53496',
            "store_address": 'CARRETERA COATZACOALCOS A BARRILLAS Km 1+300, PREDIO SAN JOAQUIN C.P. 96535 COATZACOALCOS VER.'
        },
        {
            "store_name": 'SUC MALECON',
            "lat": '18.14976',
            "lng": '-94.47306',
            "store_address": 'MALECON COSTERO N°419 COL. PARAISO, C.P. 96523, COATZACOALCOS VER.'
        }
    ];*/
    /*console.log(markers);

    window.onload = function () {
        LoadMap();
    }*/

    /*function LoadMap() {

        map = new google.maps.Map(document.getElementById('dvMap'), {
            disableDefaultUI: true,
            zoom: 10,
            gestureHandling: 'greedy',
            fullscreenControl: false,
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
            },
            styles: [
                {
                    "featureType": "poi",
                    "stylers": [
                        { "visibility": "off" }
                    ]
                },
                {
                    "featureType": "transit.station",
                    "stylers": [
                        { "visibility": "off" }
                    ]
                },
                {
                    "featureType": "administrative",
                    "stylers": [
                        { "visibility": "off" }
                    ]
                },
                {
                    "featureType": "landscape.man_made",
                    "stylers": [
                        { "visibility": "off" }
                    ]
                }
            ]

        });
        var infoWindow = new google.maps.InfoWindow();
        infowindows.push(infoWindow);
        var latlngbounds = new google.maps.LatLngBounds();


        var options = {
            bounds: google.maps.LatLngBounds( google.maps.LatLng(33.1613, -118.4766), google.maps.LatLng(14.3770, -84.8145) )
        };


        //--------
        for (var i = 0; i < markers.length; i++) {
            var data = markers[i]
            var myLatlng = new google.maps.LatLng(data.lat, data.lng);
            var marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                store_name: data.store_name,
                icon: "my-assets/image/dipe-marker_icon.png"
            });
            (function (marker, data) {
                google.maps.event.addListener(marker, "click", function (e) {
                    map.setZoom(14);
                    map.panTo(marker.position);
                    infoWindow.setContent("<div style = 'width:200px;min-height:40px'>" + data.store_name + ". " + data.store_address + "<div class = ''></div></div>");
                    infoWindow.open(map, marker);

                });
            })(marker, data);
            latlngbounds.extend(marker.position);
        }
        var bounds = new google.maps.LatLngBounds();
        map.setCenter(latlngbounds.getCenter());

        (function ($) {
            $.each(['show', 'hide'], function (i, ev) {
                var el = $.fn[ev];
                $.fn[ev] = function () {
                    this.trigger(ev);
                    return el.apply(this, arguments);
                };
            });
        })(jQuery);

    }*/

</script>