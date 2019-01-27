/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require("../css/app.sass");

// loads the jquery package from node_modules
var $ = require("jquery");

require("cd-pretty-photo");
$(document).ready(function() {
    $("a[rel^='prettyPhoto']").prettyPhoto({
        theme: 'pp_default',
        deeplinking: false,
        social_tools: false,
        show_title: false
    });
});