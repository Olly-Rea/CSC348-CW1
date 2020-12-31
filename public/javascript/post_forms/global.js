/* * * * * * * * * * * * * * * * * * * * * * * * *
 *        Shared Post Edit/Create JQuery         *
 * * * * * * * * * * * * * * * * * * * * * * * * */

 // Methods to be called on and/or added to elements on page load/pageshow
 $(window).on("load, pageshow", function() {

    // Handler for 'on' form input/textarea 'change'
    $("#post-form input, #post-form textarea").one("change", function() {
        // Add exit-confirmation message to each nav link
        $("#feed-nav a").not("#notifications a, #create a").on("click", function() {
            event.preventDefault();
            exitPrompt($(this).attr("href"));
        });
        // re-bind the beforeunload handler
        $(window).unbind("beforeunload");
        $(window).bind("beforeunload", function() {
            return "You have unsaved changes!";
        });
    });

    // Handler to display the list of available tags
    $(".tag-container a, #tag-selector").on("click", function() {
        showTags();
    });

    // Handlers to allow a user to edit a textarea input
    $("main").on("click", ".text-container #edit.menu-item", function() {
        // Get the text-container overlay
        $overlay = $(this).parent();
        // Get the text-container textarea
        $textarea = $(this).parent().parent().children().first();
        // fade out the overlay and give the textarea focus
        $overlay.hide();
        $textarea.focus();
        // console.log($textarea);
    });
    $("main").on("focus", ".text-container textarea", function() {
        // Get the text-container overlay
        $overlay = $(this).next();
        // fade out the overlay and give the textarea focus
        $overlay.hide();
    });

    // Handler to un-hide the text-container overlay
    $("main").on("focusout", ".text-container textarea", function() {
        // Get the text-container overlay
        $overlay = $(this).next();
        $overlay.fadeIn(transitionTime);
        // console.log($overlay);
    });

    // Make form inputs jQueryUI "sortable" types
    $("#post-form").sortable({ items: ".text-container, .image-container", axis: "y", handle: "#move.menu-item", update: function() {
        updatePositions();
    } });


    // Handler to delete an input container - CREATE/EDIT SPECIFIC


    // Handler to display a preview of a user-uploaded image
    $("main").on("load, change", ".image-container #edit > input", function() {
        // Get the image container
        $container = $(this).parent().parent().parent();
        // Remove the focused class (if it is present)
        if($container.hasClass("focused")) {
            $container.removeClass("focused");
        }
        // Get the image tag
        $image = $container.children().first().next();
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $image.attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    // Handlers for the addText and addImage nav items
    $("#add-text div").on("click", function() {
        // console.log("added text!");
        $.ajax({
            url:"/post/add/text",
            method:"GET",
            success: function(data) {
                $("#post-form").append(data);
            },
            error: function(data) {
                errorPrompt("Error loading new text input!");
                // console.log(data);
            }
        });
    });
    $("#add-image div").on("click", function() {
        $.ajax({
            url:"/post/add/image",
            method:"GET",
            success: function(data) {
                $("#post-form").append(data);
            },
            error: function(data) {
                errorPrompt("Error loading new image input!");
                // console.log(data);
            }
        });
    });

    // Handler to submit the post-form
    $("#save.menu-item").on("click", function() {
        // Final 'updatePositions' on form submit
        updatePositions();
        // Check each image input and prevent submission until they are filled in (or removed)
        $(".image-container").each(function() {
            // Get the image container
            $container = $(this);
            $input = $container.find("input[type=\"file\"]");
            // If the input value is null (or blank)
            if(($input.val() == null || $input.val() == "") && $input.attr("value") == null) {
                event.preventDefault();
                // Scroll to the element
                $("html, body").animate({
                    scrollTop: $container.offset().top - (9 * parseInt($('html').css('font-size'))) // translate down 9rem
                }, 250);
                // Wait until element has been scrolled to
                setTimeout(function () {
                    // Pulse the image container overlay (for 1.5 seconds)
                    $container.addClass("focused");
                    setTimeout(function () {
                        $container.removeClass("focused");
                    }, 1500);
                }, 250);
                // Break out of the loop
                return false;
            }
        });
        // re-bind the beforeunload handler
        $(window).unbind("beforeunload");
        $(window).bind("beforeunload", function() {
            windowUnload();
        });
    });
});

// Method to display the exit-page confirmation prompt
function exitPrompt(link) {
    // Show the exit prompt
    $("#site-overlay, #exit.prompt").fadeIn(transitionTime);
    // Add exit-prompt button link
    $("#exit.prompt button").on("click", function() {
        $("#exit.prompt button").off("click");
        // re-bind the beforeunload handler
        $(window).unbind("beforeunload");
        $(window).bind("beforeunload", function() {
            windowUnload();
        });
        setTimeout(function () {
            window.location.href = link;
        }, 2);
    });
    // Add cancel-prompt click handler
    $("p.cancel-prompt").on("click", function() {
        $("p.cancel-prompt").off("click");
        $("#site-overlay, #exit.prompt").fadeOut(transitionTime);
        // re-bind the beforeunload handler
        $(window).unbind("beforeunload");
        $(window).bind("beforeunload", function() {
            return "You have unsaved changes!";
        });
    });
}

// Method to show the tags overlay
function showTags() {
    // Show the sign up prompt
    $("#site-overlay, #tags.prompt").fadeIn(transitionTime);
    // Add cancel-prompt click handler
    $("p.close-prompt").on("click", function() {
        $("p.close-prompt").off("click");
        $("#site-overlay, #tags.prompt").fadeOut(transitionTime);
    });
}
