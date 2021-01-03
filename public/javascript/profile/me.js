/* * * * * * * * * * * * * * * * * * * * * * * * *
 *              Edit Profile JQuery              *
 * * * * * * * * * * * * * * * * * * * * * * * * */

  // Methods to be called on and/or added to elements on page load/pageshow
  $(window).on("load, pageshow", function() {

    $("#likes.menu-item div").on("click", function() {
        fadeContent($(this).parent(), $("#likes-container"));
    });

    // Handler to show the 'edit profile' form
    $("#settings.menu-item div").on("click", function() {
        // Show the sign up prompt
        $("body").addClass("no-scroll");
        $("#site-overlay, #scroll-padding").fadeIn(transitionTime);
        // // Add close-prompt click handler
        $("p.close-prompt").on("click", function() {
            $("p.close-prompt").off("click");
            $("#site-overlay, #scroll-padding").fadeOut(transitionTime);
            $("body").removeClass("no-scroll");
            // Scroll the edit form back to the top
            setTimeout(function () {
                $("#site-overlay").scrollTop(0);
            }, transitionTime);
        });
    });

    // Handler to display the profile image preview
    $(".image-overlay input[type=\"file\"]").on("load change", function() {
        // Get the image container
        $container = $(this).parent().parent().parent();
        // Get the image tag
        $image = $container.find("img");
        // Add the image (as a preview) to the profile-image
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $image.attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    // Disable saving until form change made
    $("#save.menu-item").on("click", function() {
        event.preventDefault();
    })
    $("#profile-form input").one("change", function() {
        $("#save.menu-item").on("click", function() {
            $("#profile-form").submit();
        });
    })

    // // Handler to display the delete profile prompt
    // $("#delete-profile").on("click", function() {
    //     $("#edit-profile").fadeOut(transitionTime);
    //     // Alter the confirmation prompt message
    //     $("#confirm.prompt > p").not("p.cancel-prompt").html("Once you delete your profile, it cannot be recovered!");
    //     // Show the confirmation prompt
    //     setTimeout(function () {
    //         $("#site-overlay").scrollTop(0);
    //         $("#confirm.prompt").fadeIn(transitionTime);
    //     }, transitionTime);
    //     // Add 'confirm' button click handler
    //     $("#confirm.prompt button").on("click", function() {
    //         $("#delete-form").submit();
    //     });
    //     // Add cancel-prompt click handler
    //     $("p.cancel-prompt").on("click", function() {
    //         $("p.cancel-prompt").off("click");
    //         $("#site-overlay, #confirm.prompt").fadeOut(transitionTime);
    //     });
    // });

    // Handler to display the delete profile prompt
    $("#logout a").on("click", function() {
        // Show the logout prompt
        $("#site-overlay, #logout.prompt").fadeIn(transitionTime);
        // Add cancel-prompt click handler
        $("p.cancel-prompt").on("click", function() {
            $("p.cancel-prompt").off("click");
            $("#site-overlay, #logout.prompt").fadeOut(transitionTime);
        });
    });


});
