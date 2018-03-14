//// Core - these two are required :-)
//import tinymce from 'tinymce/tinymce'
//import 'tinymce/themes/modern/theme'
//
//// Plugins
//import 'tinymce/plugins/paste/plugin'
//import 'tinymce/plugins/link/plugin'
//import 'tinymce/plugins/autoresize/plugin'

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

//function tinymceLoaded(inst){
//    // get the desired height of the editor
//    var height = $('#' + inst.editorId).height(); 
//
//    // when the editor is hidden, the height calculated is 0
//    // Lets use the inline style text to solve this problem
//    if(height == 0){
//        height = $('#' + inst.editorId).css('height'); // 200px
//        height = height.replace(/[^0-9]/g, "");    // remove all non-numeric characters to isolate the '200'
//    }
//
//    // set the height of the hidden TinyMCE editor
//    $('#' + inst.editorId + '_ifr').css({height: height + 'px'});
//}

jQuery(function ($)
{
//    tinymce.init({
//        selector: 'textarea.editable'
//    });

//    tinymce.init({
//        selector: 'textarea.editable',
//        height: 500,
//        menubar: false,
//        skin: false,
//        themes: 'modern',
//        plugins: [
//            'paste link'
////            'advlist autolink lists link image charmap print preview anchor textcolor',
////            'searchreplace visualblocks code fullscreen',
////            'insertdatetime media table contextmenu paste code help wordcount'
//        ],
//        //init_instance_callback: "tinymceLoaded",
//        toolbar: 'insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
//        content_css: [
//            '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
//            '//www.tinymce.com/css/codepen.min.css']
//    });

});


