/* * * * * * * * * * * * * * * * * * * * * * * * *
 *               Post Edit JQuery                *
 * * * * * * * * * * * * * * * * * * * * * * * * */

 // Methods to be called on and/or added to elements on page load/pageshow
$(window).on("load, pageshow", function() {

    // Handler to delete an input container
    $("main").on("click", "#delete.menu-item", function() {
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
