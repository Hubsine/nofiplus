function stateBillingAddress(billingAddress, childs, checkbox)
{
    if ( ! checkbox.is(':checked'))
    {
        billingAddress.show();
        childs.attr('required', 'required');
    } else 
    {
       billingAddress.hide();
       childs.removeAttr('required');
    }
}

/***
 * shipping_as_billing_address
 ***/
jQuery(function ($)
{
    var checkbox        = $('input[type="checkbox"].shipping_as_billing_address');
    var billingAddress  =  $('#billingAddress');
    var childs          = billingAddress.find('input, select, textarea');
    
    stateBillingAddress(billingAddress, childs, checkbox);
    
    checkbox.change(function ()
    {
        var checkbox = $(this);

        stateBillingAddress(billingAddress, childs, checkbox);
        
    });

});
