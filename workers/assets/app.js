import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';
import jquery from 'jquery';

const $ = require('jquery');
require('bootstrap');

$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});

require('bootstrap/dist/js/bootstrap.bundle');

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');
