jQuery(function ($)
{
    /****
     * Display category name 
     ****/

    var activeItemLink = $('.footer-category-menu li.active > a').html();
    $('.footer-category-menu .current-category-name').html(activeItemLink);


    /****
     * Toogle caret 
     ****/

    $('#navbarToggleCategoryMenu').on('show.bs.collapse', function () 
    {
        $('.toggle-footer-category-menu').removeClass('fa-caret-up').addClass('fa-caret-down');
    });
    
    $('#navbarToggleCategoryMenu').on('hide.bs.collapse', function () 
    {
        $('.toggle-footer-category-menu').removeClass('fa-caret-down').addClass('fa-caret-up');
    });
    
});