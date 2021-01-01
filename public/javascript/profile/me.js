/* * * * * * * * * * * * * * * * * * * * * * * * *
 *              Edit Profile JQuery              *
 * * * * * * * * * * * * * * * * * * * * * * * * */

  // Methods to be called on and/or added to elements on page load/pageshow
  $(window).on("load, pageshow", function() {

    $("#likes.menu-item div").on("click", function() {
        fadeContent($(this).parent(), $("#likes-container"));
    });

    // // Handler to show the 'edit profile' form
    // $("#settings.menu-item div").on("click", function() {
    //     // Show the sign up prompt
    //     $("#site-overlay, #edit-profile").fadeIn(transitionTime);
    //     // // Add close-prompt click handler
    //     $("p.close-prompt").on("click", function() {
    //         $("p.close-prompt").off("click");
    //         $("#site-overlay, #edit-profile").fadeOut(transitionTime);
    //     });
    // });

});
