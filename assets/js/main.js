import img from '../images/default_avatar.png';

/***
 * Required
 ***/

require('../scss/main.scss');

/***
 * Global Jquery Config 
 ***/

const $ = require('jquery');
          require('jquery-ui-bundle');
// create global $ and jQuery variables
global.$ = global.jQuery = $;
