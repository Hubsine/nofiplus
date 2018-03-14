function disableTextarea(checkboxs)
{
    var textareas = $('.enjoyByTextarea');

    checkboxs.each(function ()
    {
        checkbox = $(this);
        var textareaClass = '.' + checkbox.val();

        if (checkbox.is(':checked'))
        {
            if (checkbox.hasClass('all'))
            {
                // Active tout les textarea 
                textareas.removeAttr('disabled');
            } else
            {
                textareas.filter(textareaClass).removeAttr('disabled');
            }

        } else
        {
            // Si pas checked, on désactive le textarea
            textareas.filter(textareaClass).attr('disabled', 'disabled');
        }

    });
}

/***
 * Offre check box
 ***/
jQuery(function ($)
{
    $('.containDynamicCheckbox').each(function ()
    {
        var checkboxContainer = $(this);
        var checkboxs = checkboxContainer.find('input[type="checkbox"]');
        var checkedCheckbox = null;

        // First call
        checkedCheckbox = dynamicCheckboxChange(checkboxContainer, checkboxs);
        disableTextarea(checkboxs);

        checkboxs.on('change', function (e)
        {
            checkedCheckbox = dynamicCheckboxChange(checkboxContainer, checkboxs);
            disableTextarea(checkboxs);
        });

    });

});

/***
 * Date Picker
 ***/
function getDate(element, dateFormat = 'dd/mm/yy')
{
    var date;
    try {
        date = $.datepicker.parseDate( dateFormat, $(element).val() );
    } catch (error) {
        date = null;
    }


    return date;
}

jQuery(function ($)
{

    var from = $(".datepicker.start");
    var dateFormat = "dd/mm/yy";

    from.datepicker(
        {
            dateFormat: dateFormat,
            defaultDate: "today",
            changeMonth: true,
            changeYear: true,
            minDate: $.datepicker.parseDate( dateFormat, new Date().toLocaleDateString() ),
            showButtonPanel: true
        })
        .on("change", function ()
        {
            to.datepicker("option", "minDate", getDate(this));
        });
        
    var to = $(".datepicker.end").datepicker(
        {
            dateFormat: dateFormat,
            defaultDate: "+1d",
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true
        })
        .on("change", function ()
        {
            //from.datepicker("option", "maxDate", getDate(this));
        });

});