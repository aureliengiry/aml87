// loads the jquery package from node_modules
var $ = require("jquery");

require("bootstrap");
require("mdbootstrap");

$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});
