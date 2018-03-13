/***
 * Prevent Delete Entity
 ***/

jQuery(function ($)
{
    // Init confirm dialog
    $(function ()
    {
        $("#dialog-confirm").dialog({
            autoOpen: false,
            resizable: false,
            height: "auto",
            width: 400,
            modal: true
        });

    });

    $('body').on('click', '.btnDeleteEntity', function (e)
    {
        e.preventDefault();

        var targetUrl = $(this).attr('href');

        $("#dialog-confirm").dialog({
            autoOpen: true,
            buttons: {
                Supprimer: function ()
                {
                    window.location.href = targetUrl;
                },
                Annuler: function ()
                {
                    $(this).dialog("close");
                }
            }
        });

    });
});

/***
 * Tinymce Init
 ***/

jQuery(function ($)
{
    tinymce.init({
        selector: 'textarea#editable'
    });

});

/***
 * Datepicker
 ***/

jQuery(function ($)
{
    $(".datepicker").datepicker({
        changeMonth: true,
        changeYear: true
    });

});