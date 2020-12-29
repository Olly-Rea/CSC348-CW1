/* * * * * * * * * * * * * * * * * * * * * * * * *
 *          Blog comment replies JQuery          *
 * * * * * * * * * * * * * * * * * * * * * * * * */
var paginatePage = 2;

// Methods to be called on and/or added to elements on page load/pageshow
$(window).on("load, pageshow", function() {

    // Handler to display comment replies
    $("main").on("click", ".reply-button", function() {
        $(this).fadeOut(transitionTime);
        $replyContainer = $(this).next();
        setTimeout(function () {
            $replyContainer.fadeIn(transitionTime);
            fetch_data($replyContainer)
        }, transitionTime);
    });

});

// Method to get the next pagination data
function fetch_data($container) {
    // get the loading graphic from the container
    $loadingGraphic = $container.find("svg.loading-graphic");
    // get the comment id to get replies for
    commentID = $container.attr("id").match(/\d+/)[0];
    // Perform the request
    $.ajax({
        url:"/reply/fetch",
        method:"POST",
        data:{page:paginatePage++, id:commentID},
        success: function(data) {
            if(data != null && data.length > 0) {
                // Add the data to main
                $container.append(data);
                // fadeOut the "loading" graphic
                $loadingGraphic.fadeOut(transitionTime);
            } else {
                if($loadingGraphic.is(":visible")) {
                    $loadingGraphic.fadeOut(transitionTime);
                }
                $container.append("<p class=\"empty\">This comment has no replies yet!</p>");
            }
            $container.find("form").appendTo($container);
            $container.find("form").fadeIn(transitionTime);
        },
        error: function() {
            $loadingGraphic.fadeOut(transitionTime)
            $container.append("<p>Error loading data!</p>");
        }
    });
}
