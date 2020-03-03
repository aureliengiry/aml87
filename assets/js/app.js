// loads the jquery package from node_modules
const $ = require('jquery');

require('bootstrap');
// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.sass');

require('cd-pretty-photo');
$(document).ready(function () {
    $('a[rel^=\'prettyPhoto\']').prettyPhoto({
        theme: 'pp_default',
        deeplinking: false,
        social_tools: false,
        show_title: false
    });
});
