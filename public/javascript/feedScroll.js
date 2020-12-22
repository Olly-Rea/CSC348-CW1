/* * * * * * * * * * * * * * * * * * * * * * * * *
 *       Feed Pagination Scrolling JQuery        *
 * * * * * * * * * * * * * * * * * * * * * * * * */

// Scroll variables
var scrollMax = 0.7;
var paginatePage = 2;

// Methods to be called on and/or added to elements on page load/pageshow
$(window).on("load, pageshow", function() {
    // If the number of returned profiles are < 30...
    if($("main").children().length < 30) {
        // ...show the "end of feed" message
        $("main").append("<p id=\"the-end\">That's all folks!</p>");
    } else {
        // Pagination stuff
        $(window).on("scroll", function() {
            scrollFunc();
        });
    }

});

// Method to call on onscroll
function scrollFunc() {
    // If the scroll position is past the scrollMax threshold (starting at 0.75, incrementing by 0.05 each call)
    if ($(window).scrollTop() > ($("main").height() * scrollMax)) {
        // Stop the event from firing more than once
        $(window).off("scroll");

        // Increment scrollMax (if less than 90%)
        if (scrollMax < 0.9) {
            scrollMax+=0.05;
        }

        // TODO Add loading graphic at bottom of feed (unless the end of feed has been reached)

        // Fetch the next load of paginated data
        fetch_data();
    }
}

// Method to get the next pagination data
function fetch_data() {
    $.ajax({
        url:"/feed/fetch",
        method:"POST",
        data:{page:paginatePage++},
        success:function(data) {
            if(data != null && data.length > 0) {
                $("main").append(data);
                // Re-enable scroll functionality
                setTimeout(function () {
                    $(window).on("scroll", function() {
                        scrollFunc();
                    });
                }, 400);
            } else {
                // Output an "end of feed" message
                $("main").append("<p>That's all folks!</p>");
            }
        }
    });
}
