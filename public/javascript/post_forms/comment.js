/* * * * * * * * * * * * * * * * * * * * * * * * *
 *              Comment Edit JQuery              *
 * * * * * * * * * * * * * * * * * * * * * * * * */

var $container;
var $form;

 // Methods to be called on and/or added to elements on page load/pageshow
 $(window).on("load, pageshow", function() {

    // Handler to display the 'edit' form for a comment
    $("main").on("click", "#edit.menu-item", function() {
        $overlay = $(this).parent();
        // Get the comment container
        $container = $overlay.parent();
        // Get the comment edit form
        $form = $container.find(".comment-edit");

        // fade out the comment text and in the comment form
        $container.find("> p").fadeOut(transitionTime/2);
        setTimeout(function () {
            $form.fadeIn(transitionTime/2);
        }, transitionTime/2);
        // Add the edit-active class to hide the overlay
        $container.addClass("edit-active");

        // Handler to cancel form editing
        $form.find("p.form-cancel").on("click", function() {
            $form.find("p.form-cancel").off("click");
            $form.fadeOut(transitionTime/2);
            setTimeout(function () {
                $container.find("> p").fadeIn(transitionTime/2);
                setTimeout(function () {
                    $container.removeClass("edit-active");
                }, transitionTime/2);
            }, transitionTime/2);
        });
    });

    // Handler to delete a comment
    $("main").on("click", "#delete.menu-item", function() {
        // Get the comment container
        $container = $(this).parent().parent();
        // Get the reply button and reply container elements (provided they exist)
        $replyBtn = $container.next();
        if(!$replyBtn.hasClass('reply-button')) {
            // Otherwise set as false (indicates comment is a reply)
            $replyBtn = false;
        } else {
            $replyContainer = $replyBtn.next();
        }
        // Get the comment id
        id = $container.children().first().val().match(/\d+/)[0];

        // Alter the confirmation prompt message
        $("#confirm.prompt > p").not("p.cancel-prompt").html("Once a comment is deleted it cannot be recoved!");
        // Show the confirmation prompt
        $("#site-overlay, #confirm.prompt").fadeIn(transitionTime);
        // Add 'confirm' button click handler
        $("#confirm.prompt button").on("click", function() {
            $("#confirm.prompt button").off("click");
            $("#site-overlay, #confirm.prompt").fadeOut(transitionTime);
            // Perform the ajax query
            $.ajax({
                url:"/comment/delete",
                method:"GET",
                data:{id:id},
                success: function(data) {
                    if(data) {
                        // Check that the reply button exists
                        if($replyBtn != false) {
                            $container.add($replyBtn).fadeOut(transitionTime);
                            setTimeout(function () {
                                $container.add($replyBtn).add($replyContainer).remove();
                            }, transitionTime);
                        } else {
                            $container.fadeOut(transitionTime);
                            setTimeout(function () {
                                $container.remove();
                            }, transitionTime);
                        }
                    } else {
                        errorPrompt("That is not your comment to delete!");
                    }
                },
                error: function(data) {
                    errorPrompt("Error deleting comment!");
                    // console.log(data);
                }
            });
        });
        // Add cancel-prompt click handler
        $("p.cancel-prompt").on("click", function() {
            $("p.cancel-prompt").off("click");
            $("#site-overlay, #confirm.prompt").fadeOut(transitionTime);
        });
    });

    // Handler for comment edit submission
    $("main").on("submit", ".comment-edit", function() {
        event.preventDefault();
        // Get the value of the comment to edit
        let val = $(this).children().first().val();
        // Get the comment id to edit
        let id = $(this).parent().children().first().val().match(/\d+/)[0];
        // Perform the ajax query
        $.ajax({
            url:"/comment/edit",
            method:"POST",
            data:{id:id, val:val},
            success: function(data) {
                if(data) {
                    $container.find("> p").html(val);
                    $form.fadeOut(transitionTime/2);
                    setTimeout(function () {
                        $container.find("> p").fadeIn(transitionTime/2);
                        setTimeout(function () {
                            $container.removeClass("edit-active");
                        }, transitionTime/2);
                    }, transitionTime/2);
                } else {
                    errorPrompt("That is not your comment to edit!");
                }
            },
            error: function(data) {
                errorPrompt("Error editing comment!");
                // console.log(data);
            }
        });
    });

 });
