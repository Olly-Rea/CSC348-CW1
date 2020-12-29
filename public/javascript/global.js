/* * * * * * * * * * * * * * * * * * * * * * * * *
 *    JQuery Global doc for Union Collective     *
 * * * * * * * * * * * * * * * * * * * * * * * * */
transitionTime = 250;

// get the CSRF token for JQuery AJAX
$.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// Methods to be called on and/or added to elements on page load/pageshow
$(window).on("load, pageshow", function() {
    // Fade out loading screen
    $("#loading-screen").fadeOut(transitionTime);
    // Fade in all page elements
    setTimeout(function () {
        $("#logo, #feed-nav, main, footer").fadeIn(transitionTime);
    }, transitionTime);
});

// Method to be called on page unload
$(window).bind('beforeunload',function(){
    // Fade out all page elements
    $("#logo, #feed-nav, main, footer, #site-overlay").fadeOut(transitionTime);
    // Fade in loading screen
    setTimeout(function () {
        $("#loading-screen").fadeIn(transitionTime);
    }, transitionTime);
});
