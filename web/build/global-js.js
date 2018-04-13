webpackJsonp([4],{

/***/ "./assets/js/global.js":
/*!*****************************!*\
  !*** ./assets/js/global.js ***!
  \*****************************/
/*! dynamic exports provided */
/*! all exports used */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(jQuery) {/***
 * Prevent Delete Entity
 ***/

jQuery(function ($) {
    // Init confirm dialog
    $(function () {
        $("#dialog-confirm").dialog({
            autoOpen: false,
            resizable: false,
            height: "auto",
            width: 400,
            modal: true
        });
    });

    $('body').on('click', '.btnDeleteEntity', function (e) {
        e.preventDefault();

        var targetUrl = $(this).attr('href');

        $("#dialog-confirm").dialog({
            autoOpen: true,
            buttons: {
                Supprimer: function Supprimer() {
                    window.location.href = targetUrl;
                },
                Annuler: function Annuler() {
                    $(this).dialog("close");
                }
            }
        });
    });
});

/***
* Error Page - Par exempe 404 not found error
***/

jQuery(function ($) {
    var selector = 'body.error .row.align-items-center';

    fixedItemHeightByWindow(selector);

    $(window).resize(function () {
        fixedItemHeightByWindow(selector);
    });
});
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js")))

/***/ })

},["./assets/js/global.js"]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvanMvZ2xvYmFsLmpzIl0sIm5hbWVzIjpbImpRdWVyeSIsIiQiLCJkaWFsb2ciLCJhdXRvT3BlbiIsInJlc2l6YWJsZSIsImhlaWdodCIsIndpZHRoIiwibW9kYWwiLCJvbiIsImUiLCJwcmV2ZW50RGVmYXVsdCIsInRhcmdldFVybCIsImF0dHIiLCJidXR0b25zIiwiU3VwcHJpbWVyIiwid2luZG93IiwibG9jYXRpb24iLCJocmVmIiwiQW5udWxlciIsInNlbGVjdG9yIiwiZml4ZWRJdGVtSGVpZ2h0QnlXaW5kb3ciLCJyZXNpemUiXSwibWFwcGluZ3MiOiI7Ozs7Ozs7Ozs7QUFBQTs7OztBQUlBQSxPQUFPLFVBQVVDLENBQVYsRUFDUDtBQUNJO0FBQ0FBLE1BQUUsWUFDRjtBQUNJQSxVQUFFLGlCQUFGLEVBQXFCQyxNQUFyQixDQUE0QjtBQUN4QkMsc0JBQVUsS0FEYztBQUV4QkMsdUJBQVcsS0FGYTtBQUd4QkMsb0JBQVEsTUFIZ0I7QUFJeEJDLG1CQUFPLEdBSmlCO0FBS3hCQyxtQkFBTztBQUxpQixTQUE1QjtBQVFILEtBVkQ7O0FBWUFOLE1BQUUsTUFBRixFQUFVTyxFQUFWLENBQWEsT0FBYixFQUFzQixrQkFBdEIsRUFBMEMsVUFBVUMsQ0FBVixFQUMxQztBQUNJQSxVQUFFQyxjQUFGOztBQUVBLFlBQUlDLFlBQVlWLEVBQUUsSUFBRixFQUFRVyxJQUFSLENBQWEsTUFBYixDQUFoQjs7QUFFQVgsVUFBRSxpQkFBRixFQUFxQkMsTUFBckIsQ0FBNEI7QUFDeEJDLHNCQUFVLElBRGM7QUFFeEJVLHFCQUFTO0FBQ0xDLDJCQUFXLHFCQUNYO0FBQ0lDLDJCQUFPQyxRQUFQLENBQWdCQyxJQUFoQixHQUF1Qk4sU0FBdkI7QUFDSCxpQkFKSTtBQUtMTyx5QkFBUyxtQkFDVDtBQUNJakIsc0JBQUUsSUFBRixFQUFRQyxNQUFSLENBQWUsT0FBZjtBQUNIO0FBUkk7QUFGZSxTQUE1QjtBQWNILEtBcEJEO0FBcUJILENBcENEOztBQXNDQTs7OztBQUlBRixPQUFPLFVBQVNDLENBQVQsRUFDUDtBQUNHLFFBQUlrQixXQUFXLG9DQUFmOztBQUVBQyw0QkFBd0JELFFBQXhCOztBQUVBbEIsTUFBRWMsTUFBRixFQUFVTSxNQUFWLENBQWlCLFlBQ2pCO0FBQ0lELGdDQUF3QkQsUUFBeEI7QUFDSCxLQUhEO0FBS0YsQ0FYRCxFIiwiZmlsZSI6Imdsb2JhbC1qcy5qcyIsInNvdXJjZXNDb250ZW50IjpbIi8qKipcbiAqIFByZXZlbnQgRGVsZXRlIEVudGl0eVxuICoqKi9cblxualF1ZXJ5KGZ1bmN0aW9uICgkKVxue1xuICAgIC8vIEluaXQgY29uZmlybSBkaWFsb2dcbiAgICAkKGZ1bmN0aW9uICgpXG4gICAge1xuICAgICAgICAkKFwiI2RpYWxvZy1jb25maXJtXCIpLmRpYWxvZyh7XG4gICAgICAgICAgICBhdXRvT3BlbjogZmFsc2UsXG4gICAgICAgICAgICByZXNpemFibGU6IGZhbHNlLFxuICAgICAgICAgICAgaGVpZ2h0OiBcImF1dG9cIixcbiAgICAgICAgICAgIHdpZHRoOiA0MDAsXG4gICAgICAgICAgICBtb2RhbDogdHJ1ZVxuICAgICAgICB9KTtcblxuICAgIH0pO1xuXG4gICAgJCgnYm9keScpLm9uKCdjbGljaycsICcuYnRuRGVsZXRlRW50aXR5JywgZnVuY3Rpb24gKGUpXG4gICAge1xuICAgICAgICBlLnByZXZlbnREZWZhdWx0KCk7XG5cbiAgICAgICAgdmFyIHRhcmdldFVybCA9ICQodGhpcykuYXR0cignaHJlZicpO1xuXG4gICAgICAgICQoXCIjZGlhbG9nLWNvbmZpcm1cIikuZGlhbG9nKHtcbiAgICAgICAgICAgIGF1dG9PcGVuOiB0cnVlLFxuICAgICAgICAgICAgYnV0dG9uczoge1xuICAgICAgICAgICAgICAgIFN1cHByaW1lcjogZnVuY3Rpb24gKClcbiAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgIHdpbmRvdy5sb2NhdGlvbi5ocmVmID0gdGFyZ2V0VXJsO1xuICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgQW5udWxlcjogZnVuY3Rpb24gKClcbiAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgICQodGhpcykuZGlhbG9nKFwiY2xvc2VcIik7XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfVxuICAgICAgICB9KTtcblxuICAgIH0pO1xufSk7XG5cbi8qKipcbiogRXJyb3IgUGFnZSAtIFBhciBleGVtcGUgNDA0IG5vdCBmb3VuZCBlcnJvclxuKioqL1xuXG5qUXVlcnkoZnVuY3Rpb24oJClcbntcbiAgIHZhciBzZWxlY3RvciA9ICdib2R5LmVycm9yIC5yb3cuYWxpZ24taXRlbXMtY2VudGVyJztcbiAgIFxuICAgZml4ZWRJdGVtSGVpZ2h0QnlXaW5kb3coc2VsZWN0b3IpO1xuICAgXG4gICAkKHdpbmRvdykucmVzaXplKGZ1bmN0aW9uKClcbiAgIHtcbiAgICAgICBmaXhlZEl0ZW1IZWlnaHRCeVdpbmRvdyhzZWxlY3Rvcik7XG4gICB9KTtcbiAgIFxufSk7XG5cblxuXG4vLyBXRUJQQUNLIEZPT1RFUiAvL1xuLy8gLi9hc3NldHMvanMvZ2xvYmFsLmpzIl0sInNvdXJjZVJvb3QiOiIifQ==