// loads the jquery package from node_modules
const $ = require('jquery');

require('bootstrap');
require('mdbootstrap');

require('../css/members-area.sass');

$(document).ready(function () {
    $('[data-toggle="popover"]').popover();
});
