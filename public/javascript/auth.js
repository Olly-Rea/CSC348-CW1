/* * * * * * * * * * * * * * * * * * * * * * * * *
 *              Auth-specific JQuery             *
 * * * * * * * * * * * * * * * * * * * * * * * * */

// Methods to be called on and/or added to elements on page load/pageshow
$(window).on("load, pageshow", function() {
    // Method to display the logout prompt
    $("#logout").on("click", function() {
        // Show the logout prompt
        $("#site-overlay, #logout.prompt").fadeIn(transitionTime);
        // Add cancel-prompt click handler
        $("p.cancel-prompt").on("click", function() {
            $("p.cancel-prompt").off("click");
            $("#site-overlay, #logout.prompt").fadeOut(transitionTime);
        });
    });

    // Method to like content
    $("main").on("click", ".thumb-container", function() {

        // TODO Add like ajax stuff
        console.log("liked!");

    });

    // Method to submit comments
    $("#comment-form").on("submit", function() {

        // TODO Add comment ajax stuff
        console.log("commented!");

    });

});
