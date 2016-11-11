$(function () {
    $("select.select2").select2({
        placeholder: "------",
        allowClear: true
    });

    $(".bootstrapSwitch").bootstrapSwitch({
        offText: "Nee",
        onText: "Ja"
    });

    $('input[name="zipcode"]').mask('0000SS');

    $('#side-menu').metisMenu();
    auto_active_nav();
    auto_collapse_navbar();
    button_reset();
});