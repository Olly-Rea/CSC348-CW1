/* * * * * * * * * * * * * * * * * * * * * * * * *
 *               Post Edit JQuery                *
 * * * * * * * * * * * * * * * * * * * * * * * * */

 // Methods to be called on and/or added to elements on page load/pageshow
$(window).on("load, pageshow", function() {

    // Handlers for the addText and addImage nav items
    $("#add-text div").on("click", function() {
        // console.log("added text!");
        $.ajax({
            url:"/post/add/text",
            method:"GET",
            data: {editing: 1},
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
            data: {editing: 1},
            success: function(data) {
                $("#post-form").append(data);
            },
            error: function(data) {
                errorPrompt("Error loading new image input!");
                // console.log(data);
            }
        });
    });

    // Handler to delete an input container
    $("main").on("click", ".overlay #delete.menu-item", function() {
        $container = $(this).parent().parent();
        // Fade out the container and remove it from the page
        $container.fadeOut(transitionTime);
        // If the container is a new addition, remove it from the DOM
        if($container.hasClass("new")) {
            setTimeout(function () {
                $container.remove();
            }, transitionTime);
        } else {
            // Make the to_delete chex input checked (true)
            $todelete = $container.find("input[type=\"checkbox\"]").attr('checked', 'checked');
        }
    });

    // Handler for the 'delete post' button
    $("#form-nav #delete div").on("click", function() {
        // Alter the confirm prompt message
        $("#confirm.prompt > p").not("p.cancel-prompt").html("Once a post is deleted it cannot be recoved!");
        // Show the confirm prompt
        $("#site-overlay, #confirm.prompt").fadeIn(transitionTime);
        // Add 'confirm' button click handler
        $("#confirm.prompt button").on("click", function() {
            $("#post-delete").submit();
        });
        // Add cancel-prompt click handler
        $("p.cancel-prompt").on("click", function() {
            $("p.cancel-prompt").off("click");
            $("#site-overlay, #confirm.prompt").fadeOut(transitionTime);
        });
    });

});

// method to update the position of all of the inputs
function updatePositions() {
    let pos = 0;
    $(".image-container, .text-container").each(function() {
        // Get the input fields
        $content = $(this).find("input[type=\"file\"], textarea").attr("name", "content[" + (pos) + "][content]");
        $id = $(this).find("input[type=\"number\"]").first().attr("name", "content[" + (pos) + "][id]");
        // $type = $(this).find("input[type=\"text\"]").attr("name", "content[" + (pos) + "][type]");
        // $position = $(this).find("input[type=\"number\"]").last().attr("name", "content[" + (pos) + "][position]");
        $todelete = $(this).find("input[type=\"checkbox\"]").attr("name", "content[" + (pos) + "][to_delete]");
        // Increment pos
        pos++;
    });
}
