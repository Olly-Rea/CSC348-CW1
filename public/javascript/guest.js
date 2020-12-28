/* * * * * * * * * * * * * * * * * * * * * * * * *
 *             Guest-specific JQuery             *
 * * * * * * * * * * * * * * * * * * * * * * * * */

// Methods to be called on and/or added to elements on page load/pageshow
$(window).on("load, pageshow", function() {

    $("main").on("click", ".thumb-container", function() {
        showSignUpPrompt("Sign up to like content!");
    });
    $("#comment-form").on("click", function() {
        // Un-focus the input field
        $("#comment-form input").trigger("blur");
        showSignUpPrompt("Sign up to write comments!");
    });
    $("#reply-form").on("click", function() {
        // Un-focus the input field
        $("#reply-form input").trigger("blur");
        showSignUpPrompt("Sign up to reply to comments!");
    });

});

function showSignUpPrompt(msg) {
    // Alter the sign up prompt message
    $("#sign-up.prompt > h1").html(msg);
    // Show the sign up prompt
    $("#site-overlay, #sign-up.prompt").fadeIn(transitionTime);
    // Add cancel-prompt click handler
    $("p.cancel-prompt").on("click", function() {
        $("p.cancel-prompt").off("click");
        $("#site-overlay, #sign-up.prompt").fadeOut(transitionTime);
    });
}
