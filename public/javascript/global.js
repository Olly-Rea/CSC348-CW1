/* * * * * * * * * * * * * * * * * * * * * * * * *
 *    JQuery Global doc for Union Collective     *
 * * * * * * * * * * * * * * * * * * * * * * * * */

// get the CSRF token for JQuery AJAX
$.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// Methods to be called on and/or added to elements on page load/pageshow
$(window).on("load, pageshow", function() {
    // Fade out loading screen
    $("#loading-screen").fadeOut(200);
    // Fade in all page elements
    setTimeout(function () {
        $("#logo").fadeIn(200);
        $("#feed-nav").fadeIn(200);
        $("main").fadeIn(200);
        $("footer").fadeIn(200);
    }, 200);
});

$(window).bind('beforeunload',function(){
    // Fade out all page elements
    $("#logo").fadeOut(200);
    $("#feed-nav").fadeOut(200);
    $("main").fadeOut(200);
    $("footer").fadeOut(200);
    // Fade in loading screen
    setTimeout(function () {
        $("#loading-screen").fadeIn(200);
    }, 200);
});
