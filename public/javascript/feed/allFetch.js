/* * * * * * * * * * * * * * * * * * * * * * * * *
 *       Post Pagination Scrolling JQuery        *
 * * * * * * * * * * * * * * * * * * * * * * * * */

// Method to get the next pagination data
function fetch_data() {
    $.ajax({
        url:"/feed/fetch",
        method:"POST",
        data:{page:paginatePage++},
        success: function(data) {
            if(data != null && data.length > 0) {
                // Add the data to main
                $("main").append(data);
                // Move the "loading" graphic to the end of main
                $loadingGraphic.appendTo("main");
                // Re-enable scroll functionality
                setTimeout(function () {
                    $(window).on("scroll", function() {
                        scrollFunc();
                    });
                }, 400);
                if(data.length < 30) {
                    $loadingGraphic.fadeOut();
                }
            } else {
                if($loadingGraphic.is(":visible")) {
                    $loadingGraphic.fadeOut();
                }
                // Output an "end of feed" message
                $("main").append("<p>That's all for now folks!</p>");
            }
        },
        error: function() {
            errorPrompt("Error loading feed content!");
        }
    });
}
