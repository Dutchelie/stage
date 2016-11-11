function real_time_display(form_id) {
    var senddata = form_id.serialize();
    var ajaxurl = window.location.protocol + "//" + window.location.hostname + window.location.pathname;
    setInterval(function () {
        $.ajax({url: ajaxurl, data: senddata, type: 'POST', dataType: 'json'}).done(function (json) {
            if (json.result) {
                $("#ajax_search_content").replaceWith("<div id='ajax_search_content'>" + json.result + "</div>");
            }
        });
    }, 3000);
}

function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
}


function ajax_update_snack_cart(ajaxurl, senddata)
{
    $.ajax({
        url: ajaxurl,
        data: senddata,
        type: 'POST',
        dataType: 'json'
    }).done(function (json) {
        if (json.result) {
            $("ul#ajax_content").html(json.result);
            $("span.get_totaal_now").text(json.total);
        } else {
            handle_info_box(json.status, json.msg);
        }
    }).fail(function () {
        handle_info_box("error", "Neem contact met uw webmaster");
    });
}

function crop_user_image(aspectRatio)
{
    var $image = $(".image-cropper > img");
    $("#modal_user_pic").on("shown.bs.modal", function () {
        $image.cropper({
            aspectRatio: aspectRatio,
            multiple: false,
            preview: ".img-preview",
        });
    });

    $('#modal_user_pic .save').click(function () {
        var croppedCanvas;
        croppedCanvas = $image.cropper('getCroppedCanvas');
        $('img#user_pic').attr("src", croppedCanvas.toDataURL());
        $('input#user_pic').val(croppedCanvas.toDataURL());
    });

    $("input#pic").change(function () {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.readAsDataURL(this.files[0]);
            reader.onload = function (e) {
                $image.cropper("reset", true).cropper("replace", e.target.result);
            };
        }
    });
}

function selectFileWithCKFinder(elementId) {
    CKFinder.modal({
        chooseFiles: true,
        width: 800,
        height: 600,
        onInit: function (finder) {
            finder.on('files:choose', function (evt) {
                var file = evt.data.files.first();
                elementId.val(file.getUrl());
            });

            finder.on('file:choose:resizedImage', function (evt) {
                elementId.val(evt.data.resizedUrl);
            });
        }
    });
}

function auto_collapse_navbar()
{
    $(window).bind("load resize", function () {
        var topOffset = 50;
        var width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.navbar-collapse').addClass('collapse');
            topOffset = 100; // 2-row-menu
        } else {
            $('div.navbar-collapse').removeClass('collapse');
        }

        var height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        if (height < 1)
            height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
        }
    });
}

function input_reportrange(select)
{
    $(select).daterangepicker({
        ranges: {
//            'Vandaag': [moment(), moment()],
//            'Gisteren': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Afgelopen 7 dagen': [moment().subtract(6, 'days'), moment()],
            'Laatste 30 dagen': [moment().subtract(29, 'days'), moment()],
            'Deze maand': [moment().startOf('month'), moment().endOf('month')],
            'Vorige maand': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            'Hele jaar': [moment().startOf('year'), moment().endOf('year')]
        }
    }, function (start, end) {
        $(select).val(start.format('DD-MM-YYYY') + ' - ' + end.format('DD-MM-YYYY'));
    });

    $(select).val("");
}

function button_reset()
{
    $("button.reset").click(function () {
        $("form#form_search").find("select, input:text").val("");
        $("form#form_search").find('select').selectpicker('refresh');
        $('select.select2').select2("val", "");
        $('input:checkbox').removeAttr('checked');
        $("form#form_search").find('#do_ajax').val("1");
        ajax_form_search($("form#form_search"));
    });
}

function ajax_search_filter(select, selectname)
{
    $("form#form_search select[name='" + selectname + "']").val($(select).data("search_data"));
    $("form#form_search").find("select[name='" + selectname + "']").selectpicker('refresh');
    ajax_form_search($("form#form_search"));
}

function ajax_search_filter_front(select, selectname)
{
    $("form#form_search").find("input").val("");
    $("form#form_search").find('#do_ajax').val("1");
    $("#" + selectname + "").val($(select).data("search_data"));
    ajax_form_search($("form#form_search"));

}


function handle_info_box(status, msg)
{
    $('#Modal_info').modal('show');
    var title = "Informatie";
    switch (status) {
        case 'error':
            title = "<span style=color:red>Er is iets mis gegaan</span>";
            break;
        case 'good':
            title = "<span style=color:green>Success</span>";
            break;
        case 'attachment':
            title = "<span style=color:green>Bijlage</span>";
            break;
        case 'no':
            title = "Geen";
            break;
        case 'info':
            title = "<span style=color:green>Informatie</span>";
            break;
        default:
            break;
    }
    ;
    $('#Modal_info').find('div.modal-header').find('h4.modal-title').html(title);
    $('#Modal_info').find('div.modal-body').html(msg);
}

function handle_delete_file_box()
{
    $('#Modal_delete').one('show.bs.modal', function (e) {
        var dellink = window.location.protocol + "//" + window.location.hostname + window.location.pathname;
        var search_data = $(e.relatedTarget).data('search_data');

        $("button.del_link").unbind().click(function ()
        {
            $.ajax({
                url: dellink,
                type: 'POST',
                dataType: 'json',
                data: {search_data: search_data},
                beforeSend: function ( ) {
                    $('#Modal_waiting').modal('show');
                }
            }).done(function (json) {
                if (json.status === 'good') {
                    window.location.href = window.location.protocol + "//" + window.location.hostname + window.location.pathname;
                }
            }).fail(function () {
                handle_info_box("error", "Neem contact met uw webmaster");
            }).always(function () {
                $('#Modal_waiting').modal('hide');
                $('#Modal_delete').modal('hide');
            });

        });


    });
}

function handle_delete_box()
{
    $('#Modal_delete').one('show.bs.modal', function (e) {
        var dellink = $(e.relatedTarget).data('del_link');
        var id = $(e.relatedTarget).data('search_data');
        var countnow = $("span.totalcount").text();
        $("button.del_link").unbind().click(function ()
        {
            $.ajax({
                url: dellink,
                type: 'POST',
                dataType: 'json',
                data: {del_id: id},
                beforeSend: function ( ) {
                    $('#Modal_waiting').modal('show');
                }
            }).done(function (json) {
                if (json.status === 'good') {
                    $("#" + id + "").fadeOut('slow', function () {
                        $(this).remove();
                        $('span.totalcount').text(countnow - 1);
                    });
                }
                handle_info_box(json.status, json.msg);
            }).fail(function () {
                handle_info_box("error", "Neem contact met uw webmaster");
            }).always(function () {
                $('#Modal_waiting').modal('hide');
                $('#Modal_delete').modal('hide');
            });

        });


    });
}

function post_pagination()
{
    $('.pagination a').click(function () {
        $('#form_search').attr('action', $(this).get(0).href);
        $('#form_search').submit();
        return false;
    });
}
function ajax_form_search(form_id)
{
    var senddata = form_id.serialize();
    var ajaxurl = window.location.protocol + "//" + window.location.hostname + window.location.pathname;
    ajax_search(ajaxurl, senddata);
}

function ajax_pagination(select)
{
    var ajaxurl = $(select).get(0).href;
    var senddata = $("form#form_search").serialize();
    ajax_search(ajaxurl, senddata);
}

function ajax_search(ajaxurl, senddata)
{
    $.ajax({
        url: ajaxurl,
        data: senddata,
        type: 'POST',
        dataType: 'json',
        beforeSend: function () {
            $('#Modal_waiting').modal('show');
        }
    }).done(function (json) {
        if (json.type_done) {
            switch (json.type_done) {
                case 'redirect':
                    if (json.redirect_url) {
                        window.location.href = json.redirect_url;
                    }
                    break;
                default:
                    break;
            }
        }
        if (json.result) {
            $("#ajax_search_content").html(json.result);
        } else {
            handle_info_box(json.status, json.msg);
        }
    }).fail(function () {
        handle_info_box("error", "Neem contact met uw webmaster");
    }).always(function () {
        $('#Modal_waiting').modal('hide');
    });
}

function ajax_sort(ajaxurl)
{
    $('tbody#itemContainer').sortable({
        opacity: 0.6,
        revert: true,
        cursor: 'move',
        update: function (e, ui) {
            var ul = $(ui.item).closest('tbody#itemContainer');
            var index = 1000;
            var toPost = {};
            ul.find('>tr').each(function () {
                index--;
                $(this).find('input').val(index);
                toPost[$(this).find('input').attr('name')] = index;
            });
            $.ajax({
                url: ajaxurl,
                data: toPost,
                type: 'POST',
                dataType: 'json',
                beforeSend: function ()
                {
                    $('#Modal_waiting').modal('show');
                },
                success: function (json)
                {
                    $('#Modal_waiting').modal('hide');
                },
                error: function () {
                    $('#Modal_waiting').modal('hide');
                    handle_info_box("error", "Neem contact met uw webmaster");
                }
            });
        }
    });

}

function auto_active_nav()
{
    var url = window.location;

    var element = $('ul.nav a').filter(function () {
        return this.href == url || url.href.indexOf(this.href) == 0;
    }).addClass('active').parent().parent().addClass('in').parent();
    if (element.is('li')) {
        element.addClass('active');
    }
}

function line_chart(divid, json)
{
    $(divid).highcharts({
        chart: {
            type: 'line'
        },
        title: {
            text: null
        },
        xAxis: {
            categories: json.categories
        },
        yAxis: {
            title: {
                text: json.text
            }
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: false
            }
        },
        series: json.data
    });
}

function bar_chart_basis_2(divid, json)
{
    $(divid).highcharts({
        chart: {
            type: 'bar'
        },
        title: {
            text: null
        },
        xAxis: {
            categories: json.categories,
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: json.text,
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        legend: {
            reversed: true
        },
        plotOptions: {
            series: {
                stacking: 'normal'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.2f}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
//        tooltip: {
//            valueSuffix: json.valueSuffix,
//        },


        credits: {
            enabled: false
        },
        series: json.data
    });
}


function bar_chart_basis(divid, json)
{
    $(divid).highcharts({
        chart: {
            type: 'bar'
        },
        title: {
            text: null
        },
        xAxis: {
            categories: json.categories,
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: json.text,
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        tooltip: {
            valueSuffix: ' ticket'
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -40,
            y: 80,
            floating: true,
            borderWidth: 1,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            shadow: true
        },
        credits: {
            enabled: false
        },
        series: json.data
    });
}

function pie_chart_3d(divid, json)
{
    $(divid).highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45
            }
        },
        title: {
            text: ''
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true
                },
                innerSize: 100,
                depth: 45,
                showInLegend: true
            }
        },
        series: [{
                name: json.name,
                colorByPoint: true,
                data: json.data
            }]
    });
}

function pie_chart(divid, json)
{
    $(divid).highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: ''
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true
                },
                showInLegend: true
            }
        },
        series: [{
                name: json.name,
                colorByPoint: true,
                data: json.data
            }]
    });
}



function bar_chart(divid, json)
{
    $(divid).highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: ''
        },
        xAxis: {
            categories: json.categories,
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Aantal'
            }
        },
        tooltip: {
            headerFormat: '{point.key}<table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.0f}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: json.data
    });



}
function bar_chart_3d(divid, json)
{
    $(divid).highcharts({
        chart: {
            type: 'column',
            options3d: {
                enabled: true,
                alpha: 10,
                beta: 25,
                depth: 70
            }
        },
        title: {
            text: ''
        },
        xAxis: {
            categories: json.categories,
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Aamtal'
            }
        },
        tooltip: {
            headerFormat: '{point.key}<table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.0f}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                depth: 25
            }
        },
        series: json.data
    });


}

