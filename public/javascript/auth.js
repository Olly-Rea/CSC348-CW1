/* * * * * * * * * * * * * * * * * * * * * * * * *
 *              Auth-specific JQuery             *
 * * * * * * * * * * * * * * * * * * * * * * * * */

// Methods to be called on and/or added to elements on page load/pageshow
$(window).on("load, pageshow", function() {
    // Handler to display the logout prompt
    $("#logout a").on("click", function() {
        // Show the logout prompt
        $("#site-overlay, #logout.prompt").fadeIn(transitionTime);
        // Add cancel-prompt click handler
        $("p.cancel-prompt").on("click", function() {
            $("p.cancel-prompt").off("click");
            $("#site-overlay, #logout.prompt").fadeOut(transitionTime);
        });
    });

    // Handler to call on the Notification Panel toggle method
    $("#notifications a").on("click", function() {
        toggleNotificationPanel();
    });

    // Handler to like content
    $("main").on("click", ".thumb-container", function() {
        // Define this (so it can also be used inside the ajax method)
        $this = $(this);
        // Get the likeable_type and likeable_id identifier
        $likeable = $this.parent().children().first().val();
        // Get the likeable_type (and capitalise it)
        likeableType = $likeable.match(/[a-zA-Z]{0,}/)[0];
        likeableType = likeableType.charAt(0).toUpperCase() + likeableType.slice(1)
        // Get the likeable_id
        likeableID = $likeable.match(/\d+/)[0];
        // Perform the ajax request
        $.ajax({
            type : 'POST',
            url : "/like",
            data: {'likeable_type': likeableType, 'likeable_id': likeableID},
            success: function(data) {
                if(data) { console.log(data); }
                // get the like counter
                $likeCount = $this.children().last();
                // Add or remove the 'liked' class and increment/decrement the like count
                if ($this.hasClass("liked")) {
                    $this.removeClass("liked");
                    $likeCount.html(parseInt($likeCount.html())-1);
                } else {
                    $this.addClass("liked");
                    $likeCount.html(parseInt($likeCount.html())+1);
                }
            },
            error: function(data) {
                if (likeableType == "Post") {
                    errorPrompt("Error liking this post!");
                } else {
                    errorPrompt("Error liking this comment!");
                }
                // console.log(data);
            }
        });
    });

    // Handler to submit comments
    $("main").on("submit", "#comment-form, .reply-form", function() {
        // Prevent default action
        event.preventDefault();
        // Get the commentable_type and commentable_id identifier
        $commentable = $(this).children().first().val();
        // Get the commentable_type (and capitalise it)
        commentableType = $commentable.match(/[a-zA-Z]{0,}/)[0];
        commentableType = commentableType.charAt(0).toUpperCase() + commentableType.slice(1)
        // Get the commentable_id
        commentableID = $commentable.match(/\d+/)[0];
        // Get the the commentable input
        $input = $(this).children().last().find("input");
        // Perform the ajax request
        $.ajax({
            type : 'POST',
            url : "/comment/create",
            // data: {'user_id': likeableType, 'commentable_id': likeableID, 'content': input},
            data: {'commentable_type': commentableType, 'commentable_id': commentableID, 'content': $input.val()},
            success: function(data) {
                // Check the commentable_type, and add the data to the appropriate container
                if (commentableType == "Post") {
                    $empty = $("#comment-container").find("p.empty");
                    if($empty.length == 1) {
                        // ...fadeOut the .empty indicator
                        $empty.fadeOut(transitionTime);
                        // and append the data
                        setTimeout(function () {
                            $("#comment-container").append(data);
                        }, transitionTime);
                    } else {
                        $("#comment-container").append(data);
                    }
                } else {
                    // Get the correct reply-container to append to
                    replyContainer = "#comment-"+commentableID+".reply-container"
                    // Get the reply-form
                    $replyForm = $(replyContainer).children().last();
                    // If the reply-container is empty (and so contains the 'empty' message)...
                    $empty = $(replyContainer).find("p.empty");
                    if($empty.length == 1) {
                        // ...fadeOut the .empty indicator
                        $empty.fadeOut(transitionTime);
                        // and append the data
                        setTimeout(function () {
                            $(replyContainer).append(data);
                            // Move the reply-form to the bottom of the reply-container
                            $(replyContainer).append($replyForm);
                        }, transitionTime);
                    } else {
                        $(replyContainer).append(data);
                        // Move the reply-form to the bottom of the reply-container
                        $(replyContainer).append($replyForm);
                    }
                }
                // Reset the input value
                $input.val("");
            },
            error: function(data) {
                if (commentableType == "Post") {
                    errorPrompt("Error commenting on this post!");
                } else {
                    errorPrompt("Error replying to this comment!");
                }
                // console.log(data);
            }
        });
    });
});

// Method to toggle the Notification Panel
function toggleNotificationPanel() {
    // Prevent multiple clicks
    $("#notifications a").off("click");
    if($("#notifications").hasClass("active")) {
        $("#notifications, #notification-container").removeClass("active");
        setTimeout(function () {
            $("#notification-container").hide();
        }, transitionTime);
    }else {
        $("#notification-container").show();
        $("#notifications, #notification-container").addClass("active");
    }
    setTimeout(function () {
        $("#notifications a").on("click", function() {
            toggleNotificationPanel();
        });
    }, transitionTime);
}
