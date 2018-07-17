require('../css/app.scss');

const $ = require('jquery');
global.$ = global.jQuery = $;

const routes = require('../../public/js/fos_js_routes.json');
import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';

Routing.setRoutingData(routes);

require('bootstrap');
require('moment-js');
require('fullcalendar');
