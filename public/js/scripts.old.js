/***
 * Javascript para loading in tela
 */

var Scripts = [];
/**
 * Funções de feedback
 */
Scripts.feedback = function () {
    $('.feedback').fadeIn();
    setTimeout(function () {
        $('.feedback').fadeOut();
    }, 4000);

}

$(document).ready(function () {
    Scripts.feedback();
});