$(function () {
    $(".bootstrapSwitch").bootstrapSwitch({
        offText: "Nee",
        onText: "Ja"
    });

//    $('.selectpicker').selectpicker({
//        style: 'btn-default',
//        size: 4
//    });

    //Initiat WOW JS
    new WOW().init();
});


function ajax_pagination_search(select)
{
    var ajaxurl = $(select).get(0).href;
    var senddata = $("form#form_search").serialize();
    $.ajax({
        url: ajaxurl,
        data: senddata,
        type: 'POST',
        dataType: 'json'
    }).done(function (json) {
        if (json.result) {
            $("#list_result").html(json.result_2);
        } else {
            handle_info_box(json.status, json.msg);
        }
    }).fail(function () {
        handle_info_box("error", "Neem contact met uw webmaster");
    });
}




function get_location_by_zipcode()
{
    var options = {
        onComplete: function (cep) {
            var ajaxurl = "ajax/get_geo_by_city";
            var senddata = {zipcode: cep};
            $.ajax({
                url: ajaxurl,
                data: senddata,
                type: 'POST',
                dataType: 'json'
            }).done(function (json) {
                if (json.status === 'error') {
                    $('input[name="zipcode"]').focus();
                    handle_info_box(json.status, json.msg);
                } else {
                    $('#geo_lat').val(json.lat);
                    $('#get_lng').val(json.lng);
                    show_google_map_front_search($("#max_distance").val(), []);
                }
            }).fail(function () {
                handle_info_box("error", "Neem contact met uw webmaster");
            });
        }
    };

    $('input[name="zipcode"]').mask("0000", options);
}

function show_google_map_front_search(distance_now, locations)
{
    $("#googleMap").css("width", '100%').css("height", 600);
    var mypostion = new google.maps.LatLng($('#geo_lat').val(), $('#get_lng').val());

    var map = new google.maps.Map(document.getElementById('googleMap'), {
        zoom: 10,
        disableDefaultUI: true,
        center: mypostion,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });


    var marker_now = new google.maps.Marker({
        position: mypostion,
        map: map,
        title: 'Ik ben hier!'
    });

    var radius;
    if (distance_now > 99) {
        radius = 0;
    } else {
        radius = distance_now * 1000;
    }
    var circle = new google.maps.Circle({
        center: mypostion,
        radius: radius,
        strokeColor: "#0000FF",
        fillColor: "#0000FF",
        map: map
    });


    if (locations.length > 0) {
        var infowindow = new google.maps.InfoWindow();
        //circle.setMap(null);
        marker_now.setVisible(false);
        var marker, i;
        var markers = [];
        var finalLatLng = new google.maps.LatLng();
        for (i = 0; i < locations.length; i++) {

            var pos = new google.maps.LatLng(locations[i]['lat'], locations[i]['lng']);

            if (pos.equals(pos)) {
                //update the position of the coincident marker by applying a small multipler to its coordinates
                var newLat = pos.lat() + (Math.random() - 0.5) / 1500;// * (Math.random() * (max - min) + min);
                var newLng = pos.lng() + (Math.random() - 0.5) / 1500;// * (Math.random() * (max - min) + min);
                finalLatLng = new google.maps.LatLng(newLat, newLng);
            }

            marker = new google.maps.Marker({
                position: finalLatLng,
                map: map,
                icon: {
                    url: locations[i]['icon'],
                    scaledSize: new google.maps.Size(25, 25)
                },
                animation: google.maps.Animation.DROP
            });
            google.maps.event.addListener(marker, 'click', (function (marker, i) {
                return function () {
                    infowindow.setContent(locations[i]['iw_content']);
                    infowindow.open(map, marker);
                }
            })(marker, i));
            markers.push(marker);
        }
        var markerCluster = new MarkerClusterer(map, markers, {imagePath: 'assets/img/googlemaps/m'});

    }

    $("#max_distance").slider({
        formatter: function (v) {
            if (v > 99) {
                $('.slider-selection').css('background', '#b52b27');  //red
                $("#amount").text('onbeperk');
                circle.setRadius(0);
                return 'Onbeperk';
            } else if (v > 60) {
                $('.slider-selection').css('background', '#f0ad4e');  //yellow
                $("#amount").text(v);
                circle.setRadius(v * 1000);
                return v;
            } else {
                $('.slider-selection').css('background', '#5cb85c');  //green
                $("#amount").text(v);
                circle.setRadius(v * 1000);
                return v;
            }
        },
        step: 1, min: 10, max: 100
    });
}