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

    // Handler to submit the post-form
    $("#save.menu-item").on("click", function() {
        // Final 'updatePositions' on form submit
        updatePositions();
        // Check each image input and prevent submission until they are filled in (or removed)
        checkImageInputs();
        // Check that the user has at least one 'content' element in their post
        if($("#post-form div:visible").length < 3) {
            event.preventDefault();
            warningPrompt("You must have at least one element in your post!");
        } else {
            $("#publish-input").val("0");
            // re-bind the beforeunload handler
            $(window).unbind("beforeunload");
            $(window).bind("beforeunload", function() {
                windowUnload();
            });
        }
    });

    $("#publish.menu-item").on("click", function() {
        // Final 'updatePositions' on form submit
        updatePositions();
        // Check that the user has at least one 'content' element in their post
        if($("#post-form div:visible").length < 3) {
            event.preventDefault();
            warningPrompt("You must have at least one element in your post!");
        } else {
            // Check each image and text input and prevent submission until they are filled in (or removed)
            if(checkTitle() && checkImageInputs() && checkTextInputs() && $("#publish-input").val() == "0") {
                event.preventDefault();
                // Alter the confirm prompt message
                $("#confirm.prompt > p").not("p.cancel-prompt").html("This will save any changes, and make your post public!");
                // Show the confirm prompt
                $("#site-overlay, #confirm.prompt").fadeIn(transitionTime);
                // Add 'confirm' button click handler
                $("#confirm.prompt button").on("click", function() {
                    $("#publish-input").val("1")
                    // re-bind the beforeunload handler
                    $(window).unbind("beforeunload");
                    $(window).bind("beforeunload", function() {
                        windowUnload();
                    });
                    $("#post-form").submit();
                });
                // Add cancel-prompt click handler
                $("p.cancel-prompt").on("click", function() {
                    $("p.cancel-prompt").off("click");
                    $("#site-overlay, #confirm.prompt").fadeOut(transitionTime);
                });
            }
        }

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

function checkTitle() {

    console.log($("#title-input").val());

    if($("#title-input").val() == '') {
        return false;
    } else {
        return true
    }
}

// Method to check if each image input (which is visible) has an input (if /create or /edit) or a value (if /edit)
function checkImageInputs() {
    $finished = true;
    $(".image-container:visible").each(function() {
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
            $finished = false;
            return $finished;
        }
    });
    return $finished;
}
// Method to check if each text input (which is visible) has an input
function checkTextInputs() {
    $finished = true;
    $(".text-container:visible").each(function() {
        // Get the image container
        $container = $(this);
        $input = $container.find("textarea");
        // If the input value is null (or blank)
        if($input.prop('required') && $input.val() == '') {
            // Break out of the loop
            $finished = false;
            return $finished;
        }
    });
    return $finished;
}
