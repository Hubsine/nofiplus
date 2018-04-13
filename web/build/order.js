webpackJsonp([1],{

/***/ "./assets/js/pages/order.js":
/*!**********************************!*\
  !*** ./assets/js/pages/order.js ***!
  \**********************************/
/*! dynamic exports provided */
/*! all exports used */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(jQuery) {function stateBillingAddress(billingAddress, childs, checkbox) {
    if (!checkbox.is(':checked')) {
        billingAddress.show();
        childs.attr('required', 'required');
    } else {
        billingAddress.hide();
        childs.removeAttr('required');
    }
}

/***
 * shipping_as_billing_address
 ***/
jQuery(function ($) {
    var checkbox = $('input[type="checkbox"].shipping_as_billing_address');
    var billingAddress = $('#billingAddress');
    var childs = billingAddress.find('input, select, textarea');

    stateBillingAddress(billingAddress, childs, checkbox);

    checkbox.change(function () {
        var checkbox = $(this);

        stateBillingAddress(billingAddress, childs, checkbox);
    });
});
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js")))

/***/ })

},["./assets/js/pages/order.js"]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvanMvcGFnZXMvb3JkZXIuanMiXSwibmFtZXMiOlsic3RhdGVCaWxsaW5nQWRkcmVzcyIsImJpbGxpbmdBZGRyZXNzIiwiY2hpbGRzIiwiY2hlY2tib3giLCJpcyIsInNob3ciLCJhdHRyIiwiaGlkZSIsInJlbW92ZUF0dHIiLCJqUXVlcnkiLCIkIiwiZmluZCIsImNoYW5nZSJdLCJtYXBwaW5ncyI6Ijs7Ozs7Ozs7OztBQUFBLHVEQUFTQSxtQkFBVCxDQUE2QkMsY0FBN0IsRUFBNkNDLE1BQTdDLEVBQXFEQyxRQUFyRCxFQUNBO0FBQ0ksUUFBSyxDQUFFQSxTQUFTQyxFQUFULENBQVksVUFBWixDQUFQLEVBQ0E7QUFDSUgsdUJBQWVJLElBQWY7QUFDQUgsZUFBT0ksSUFBUCxDQUFZLFVBQVosRUFBd0IsVUFBeEI7QUFDSCxLQUpELE1BS0E7QUFDR0wsdUJBQWVNLElBQWY7QUFDQUwsZUFBT00sVUFBUCxDQUFrQixVQUFsQjtBQUNGO0FBQ0o7O0FBRUQ7OztBQUdBQyxPQUFPLFVBQVVDLENBQVYsRUFDUDtBQUNJLFFBQUlQLFdBQWtCTyxFQUFFLG9EQUFGLENBQXRCO0FBQ0EsUUFBSVQsaUJBQW1CUyxFQUFFLGlCQUFGLENBQXZCO0FBQ0EsUUFBSVIsU0FBa0JELGVBQWVVLElBQWYsQ0FBb0IseUJBQXBCLENBQXRCOztBQUVBWCx3QkFBb0JDLGNBQXBCLEVBQW9DQyxNQUFwQyxFQUE0Q0MsUUFBNUM7O0FBRUFBLGFBQVNTLE1BQVQsQ0FBZ0IsWUFDaEI7QUFDSSxZQUFJVCxXQUFXTyxFQUFFLElBQUYsQ0FBZjs7QUFFQVYsNEJBQW9CQyxjQUFwQixFQUFvQ0MsTUFBcEMsRUFBNENDLFFBQTVDO0FBRUgsS0FORDtBQVFILENBaEJELEUiLCJmaWxlIjoib3JkZXIuanMiLCJzb3VyY2VzQ29udGVudCI6WyJmdW5jdGlvbiBzdGF0ZUJpbGxpbmdBZGRyZXNzKGJpbGxpbmdBZGRyZXNzLCBjaGlsZHMsIGNoZWNrYm94KVxue1xuICAgIGlmICggISBjaGVja2JveC5pcygnOmNoZWNrZWQnKSlcbiAgICB7XG4gICAgICAgIGJpbGxpbmdBZGRyZXNzLnNob3coKTtcbiAgICAgICAgY2hpbGRzLmF0dHIoJ3JlcXVpcmVkJywgJ3JlcXVpcmVkJyk7XG4gICAgfSBlbHNlIFxuICAgIHtcbiAgICAgICBiaWxsaW5nQWRkcmVzcy5oaWRlKCk7XG4gICAgICAgY2hpbGRzLnJlbW92ZUF0dHIoJ3JlcXVpcmVkJyk7XG4gICAgfVxufVxuXG4vKioqXG4gKiBzaGlwcGluZ19hc19iaWxsaW5nX2FkZHJlc3NcbiAqKiovXG5qUXVlcnkoZnVuY3Rpb24gKCQpXG57XG4gICAgdmFyIGNoZWNrYm94ICAgICAgICA9ICQoJ2lucHV0W3R5cGU9XCJjaGVja2JveFwiXS5zaGlwcGluZ19hc19iaWxsaW5nX2FkZHJlc3MnKTtcbiAgICB2YXIgYmlsbGluZ0FkZHJlc3MgID0gICQoJyNiaWxsaW5nQWRkcmVzcycpO1xuICAgIHZhciBjaGlsZHMgICAgICAgICAgPSBiaWxsaW5nQWRkcmVzcy5maW5kKCdpbnB1dCwgc2VsZWN0LCB0ZXh0YXJlYScpO1xuICAgIFxuICAgIHN0YXRlQmlsbGluZ0FkZHJlc3MoYmlsbGluZ0FkZHJlc3MsIGNoaWxkcywgY2hlY2tib3gpO1xuICAgIFxuICAgIGNoZWNrYm94LmNoYW5nZShmdW5jdGlvbiAoKVxuICAgIHtcbiAgICAgICAgdmFyIGNoZWNrYm94ID0gJCh0aGlzKTtcblxuICAgICAgICBzdGF0ZUJpbGxpbmdBZGRyZXNzKGJpbGxpbmdBZGRyZXNzLCBjaGlsZHMsIGNoZWNrYm94KTtcbiAgICAgICAgXG4gICAgfSk7XG5cbn0pO1xuXG5cblxuLy8gV0VCUEFDSyBGT09URVIgLy9cbi8vIC4vYXNzZXRzL2pzL3BhZ2VzL29yZGVyLmpzIl0sInNvdXJjZVJvb3QiOiIifQ==