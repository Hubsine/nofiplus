/**
 * Checkbox selection
 * Pour que cela fonction il faut que : 
 * - Un checkbox qui a la class 'all'
 * - tous les autres élèments doivent avoir la class 'checkboxItem'
 * 
 * @param {type} checkboxContainer
 * @param {type} checkboxs
 * @returns {checkedCheckbox}
 */
function dynamicCheckboxChange(checkboxContainer, checkboxs)
{
    checkedCheckbox = checkboxs.filter(':checked');
    
    if ( checkedCheckbox.length > 0 && checkedCheckbox.hasClass( 'all' ) )
    {
        checkboxs.filter('.checkboxItem').prop('checked', true).prop('disabled', true);
    }
    else
    {
        checkboxs.removeAttr('disabled');
    }
    
    return checkedCheckbox;
}
window.dynamicCheckboxChange = dynamicCheckboxChange;