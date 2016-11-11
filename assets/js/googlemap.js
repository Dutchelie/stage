function show_google_map(distance_now)
{
    var mypostion = new google.maps.LatLng($('#geo_lat').val(), $('#get_lng').val());
    var mapProp = {
        center: mypostion,
        zoom: 8,
        disableDefaultUI: true,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
    
    
    var marker = new google.maps.Marker({
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


    $("#googleMap").css("width", '100%').css("height", 600);


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
        }
    });
}

function max_distance(ajax_get_geo_url)
{

    $("#max_distance").slider({
        formatter: function (v) {
            if (v > 99) {
                $('.slider-selection').css('background', '#b52b27');  //red
                $("#amount").text('onbeperk');
                return 'Onbeperk';
            } else if (v > 60) {
                $('.slider-selection').css('background', '#f0ad4e');  //yellow
                $("#amount").text(v);
                return v;
            } else {
                $('.slider-selection').css('background', '#5cb85c');  //green
                $("#amount").text(v);
                return v;
            }
        },
        step: 1, min: 10, max: 100
    });



    $('a[href="#distancedata"]').on('shown.bs.tab', function () {
        var zipcode = $('input[name="zipcode"]').val();
        var housenr = $('input[name="housenr"]').val();
        $.ajax({
            url: ajax_get_geo_url,
            type: 'POST',
            dataType: 'json',
            data: {zipcode: zipcode, housenr: housenr}
        }).done(function (json) {
            if (json.status === 'error') {
                $('#distancedata_body').hide();
                switch_tab_box("distancedata", "profile");
                handle_info_box(json.status, json.msg);
            } else {
                $('#geo_lat').val(json.lat);
                $('#get_lng').val(json.lng);
                $('#distancedata_body').show();
                show_google_map($("#max_distance").val());
            }
        }).fail(function () {
            handle_info_box("error", "Neem contact met uw webmaster");
        });
    });

}

function setting_distance_by_city(ajax_get_geo_url)
{

    $("#max_distance").slider({
        formatter: function (v) {
            if (v > 99) {
                $('.slider-selection').css('background', '#b52b27');  //red
                $("#amount").text('onbeperk');
                return 'Onbeperk';
            } else if (v > 60) {
                $('.slider-selection').css('background', '#f0ad4e');  //yellow
                $("#amount").text(v);
                return v;
            } else {
                $('.slider-selection').css('background', '#5cb85c');  //green
                $("#amount").text(v);
                return v;
            }
        },
        step: 1, min: 10, max: 100
    });



    $('a[href="#distancedata"]').on('shown.bs.tab', function () {
        var zipcode = $('input[name="zipcode"]').val();
        $.ajax({
            url: ajax_get_geo_url,
            type: 'POST',
            dataType: 'json',
            data: {zipcode: zipcode}
        }).done(function (json) {
            if (json.status === 'error') {
                $('#distancedata_body').hide();
                switch_tab_box("distancedata", "profile");
                handle_info_box(json.status, json.msg);
            } else {
                $('#geo_lat').val(json.lat);
                $('#get_lng').val(json.lng);
                $('#distancedata_body').show();
                show_google_map($("#max_distance").val());
            }
        }).fail(function () {
            handle_info_box("error", "Neem contact met uw webmaster");
        });
    });

}

function switch_tab_box(from, to)
{
    $("li#tab_" + from + "").removeClass("active");
    $("div#" + from + "").removeClass("active");
    $("li#tab_" + to + "").addClass("active");
    $("div#" + to + "").addClass("active");
}