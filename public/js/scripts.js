/***
 * Javascript para loading in tela
 */

var Scripts = [];
/**
 * Funções de feedback
 */
Scripts.flashMessage = function () {
    // Toastr options
    toastr.options = {
        "debug": false,
        "newestOnTop": false,
        "positionClass": "toast-top-center",
        "closeButton": true,
        "toastClass": "animated fadeInDown",
    };
};

$(document).ready(function () {
    Scripts.flashMessage();
});