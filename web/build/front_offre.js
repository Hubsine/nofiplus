webpackJsonp([3],{

/***/ "./assets/js/pages/front_offre.js":
/*!****************************************!*\
  !*** ./assets/js/pages/front_offre.js ***!
  \****************************************/
/*! dynamic exports provided */
/*! all exports used */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(jQuery) {jQuery(function ($) {
    /****
     * Display category name 
     ****/

    var activeItemLink = $('.footer-category-menu li.active > a').html();
    $('.footer-category-menu .current-category-name').html(activeItemLink);

    /****
     * Toogle caret 
     ****/

    $('#navbarToggleCategoryMenu').on('show.bs.collapse', function () {
        $('.toggle-footer-category-menu').removeClass('fa-caret-up').addClass('fa-caret-down');
    });

    $('#navbarToggleCategoryMenu').on('hide.bs.collapse', function () {
        $('.toggle-footer-category-menu').removeClass('fa-caret-down').addClass('fa-caret-up');
    });
});
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js")))

/***/ })

},["./assets/js/pages/front_offre.js"]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvanMvcGFnZXMvZnJvbnRfb2ZmcmUuanMiXSwibmFtZXMiOlsialF1ZXJ5IiwiJCIsImFjdGl2ZUl0ZW1MaW5rIiwiaHRtbCIsIm9uIiwicmVtb3ZlQ2xhc3MiLCJhZGRDbGFzcyJdLCJtYXBwaW5ncyI6Ijs7Ozs7Ozs7OztBQUFBLDhDQUFBQSxPQUFPLFVBQVVDLENBQVYsRUFDUDtBQUNJOzs7O0FBSUEsUUFBSUMsaUJBQWlCRCxFQUFFLHFDQUFGLEVBQXlDRSxJQUF6QyxFQUFyQjtBQUNBRixNQUFFLDhDQUFGLEVBQWtERSxJQUFsRCxDQUF1REQsY0FBdkQ7O0FBR0E7Ozs7QUFJQUQsTUFBRSwyQkFBRixFQUErQkcsRUFBL0IsQ0FBa0Msa0JBQWxDLEVBQXNELFlBQ3REO0FBQ0lILFVBQUUsOEJBQUYsRUFBa0NJLFdBQWxDLENBQThDLGFBQTlDLEVBQTZEQyxRQUE3RCxDQUFzRSxlQUF0RTtBQUNILEtBSEQ7O0FBS0FMLE1BQUUsMkJBQUYsRUFBK0JHLEVBQS9CLENBQWtDLGtCQUFsQyxFQUFzRCxZQUN0RDtBQUNJSCxVQUFFLDhCQUFGLEVBQWtDSSxXQUFsQyxDQUE4QyxlQUE5QyxFQUErREMsUUFBL0QsQ0FBd0UsYUFBeEU7QUFDSCxLQUhEO0FBS0gsQ0F4QkQsRSIsImZpbGUiOiJmcm9udF9vZmZyZS5qcyIsInNvdXJjZXNDb250ZW50IjpbImpRdWVyeShmdW5jdGlvbiAoJClcbntcbiAgICAvKioqKlxuICAgICAqIERpc3BsYXkgY2F0ZWdvcnkgbmFtZSBcbiAgICAgKioqKi9cblxuICAgIHZhciBhY3RpdmVJdGVtTGluayA9ICQoJy5mb290ZXItY2F0ZWdvcnktbWVudSBsaS5hY3RpdmUgPiBhJykuaHRtbCgpO1xuICAgICQoJy5mb290ZXItY2F0ZWdvcnktbWVudSAuY3VycmVudC1jYXRlZ29yeS1uYW1lJykuaHRtbChhY3RpdmVJdGVtTGluayk7XG5cblxuICAgIC8qKioqXG4gICAgICogVG9vZ2xlIGNhcmV0IFxuICAgICAqKioqL1xuXG4gICAgJCgnI25hdmJhclRvZ2dsZUNhdGVnb3J5TWVudScpLm9uKCdzaG93LmJzLmNvbGxhcHNlJywgZnVuY3Rpb24gKCkgXG4gICAge1xuICAgICAgICAkKCcudG9nZ2xlLWZvb3Rlci1jYXRlZ29yeS1tZW51JykucmVtb3ZlQ2xhc3MoJ2ZhLWNhcmV0LXVwJykuYWRkQ2xhc3MoJ2ZhLWNhcmV0LWRvd24nKTtcbiAgICB9KTtcbiAgICBcbiAgICAkKCcjbmF2YmFyVG9nZ2xlQ2F0ZWdvcnlNZW51Jykub24oJ2hpZGUuYnMuY29sbGFwc2UnLCBmdW5jdGlvbiAoKSBcbiAgICB7XG4gICAgICAgICQoJy50b2dnbGUtZm9vdGVyLWNhdGVnb3J5LW1lbnUnKS5yZW1vdmVDbGFzcygnZmEtY2FyZXQtZG93bicpLmFkZENsYXNzKCdmYS1jYXJldC11cCcpO1xuICAgIH0pO1xuICAgIFxufSk7XG5cblxuLy8gV0VCUEFDSyBGT09URVIgLy9cbi8vIC4vYXNzZXRzL2pzL3BhZ2VzL2Zyb250X29mZnJlLmpzIl0sInNvdXJjZVJvb3QiOiIifQ==