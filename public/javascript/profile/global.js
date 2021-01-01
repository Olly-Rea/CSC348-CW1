/* * * * * * * * * * * * * * * * * * * * * * * * *
 *            General Profile JQuery             *
 * * * * * * * * * * * * * * * * * * * * * * * * */

// Methods to be called on and/or added to elements on page load/pageshow
$(window).on("load, pageshow", function() {
    // Handlers for profile info navigation
    $("#about.menu-item div").on("click", function() {
        fadeContent($(this).parent(), $("#about-container"));
    });
    $("#posts.menu-item div").on("click", function() {
        fadeContent($(this).parent(), $("#posts-container"));
    });
});

// Method to fade transition between profile content
function fadeContent($nav, $elem) {
    // Loop through and remove the active class from any nav items (hopefully just the one) that have it
    $("#profile-nav").children().each(function() {
        if($(this).hasClass("active")) {
            $(this).removeClass("active");
        }
    });
    // Fade out all visible content
    $("#profile-content").children().each(function() {
        if($(this).is(":visible")) {
            $(this).fadeOut(transitionTime);
        }
    });
    // Fade in the new content
    setTimeout(function () {
        $nav.addClass("active");
        $elem.fadeIn(transitionTime);
    }, transitionTime);
}
