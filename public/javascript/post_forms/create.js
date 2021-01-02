/* * * * * * * * * * * * * * * * * * * * * * * * *
 *               Post Create JQuery              *
 * * * * * * * * * * * * * * * * * * * * * * * * */

 // Methods to be called on and/or added to elements on page load/pageshow
$(window).on("load, pageshow", function() {

    // Handlers for the addText and addImage nav items
    $("#add-text div").on("click", function() {
        // console.log("added text!");
        $.ajax({
            url:"/post/add/text",
            method:"GET",
            data: {editing: 0},
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
            data: {editing: 0},
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
    $("main").on("click", "#delete.menu-item", function() {
        $container = $(this).parent().parent();
        // Fade out the container and remove it from the page
        $container.fadeOut(transitionTime);
        setTimeout(function () {
            $container.remove();
        }, transitionTime);
    })
});

function updatePositions() {
    // Set the position of all of the inputs
    let pos = 0;
    $(".image-container, .text-container").each(function() {
        // Get the input fields
        $content = $(this).find("input[type=\"file\"], textarea").attr("name", "content[" + (pos++) + "]");
    });
}
