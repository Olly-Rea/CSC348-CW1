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

    // Handler for search submission
    $("#search-box").on("submit", function() {
        // Prevent default action
        event.preventDefault();
        // Reset value (and drop focus)
        $("#search-box input").val("");
        $("#search-box input").trigger("blur");
        // Output WIP message to the user
        messagePrompt("Feature coming soon!");
    });

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

// Method to show the 'message' prompt
function messagePrompt(msg) {
    // Alter the message prompt message
    $("#message.prompt > h1").html(msg);
    // Show the message prompt
    $("#site-overlay, #message.prompt").fadeIn(transitionTime);
    // Add close-prompt click handler
    $("#message.prompt button").on("click", function() {
        $("#message.prompt button").off("click");
        $("#site-overlay, #message.prompt").fadeOut(transitionTime);
    });
}
