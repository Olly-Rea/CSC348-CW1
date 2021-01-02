/* * * * * * * * * * * * * * * * * * * * * * * * *
 *              Comment Edit JQuery              *
 * * * * * * * * * * * * * * * * * * * * * * * * */

 // Methods to be called on and/or added to elements on page load/pageshow
 $(window).on("load, pageshow", function() {

    $(".comment-edit").on("submit", function() {
        event.preventDefault();
        // Get the value of the comment to edit
        let val = $(this).children().first().val();
        // Get the comment id to edit
        let id = $(this).parent().children().first().val().match(/\d+/)[0];

        console.log(id);
        // // Perform the ajax query
        // $.ajax({
        //     url:"/comment/edit",
        //     method:"GET",
        //     data:{comment:val},
        //     success: function(data) {
        //         $("#post-form").append(data);
        //     },
        //     error: function(data) {
        //         errorPrompt("Error loading new image input!");
        //         // console.log(data);
        //     }
        // });
    })

    // $(".comment-edit").on("submit", function() {
    //     event.preventDefault();
    //     // Get the value of the comment to edit
    //     let val = $(this).children().first().val();

    //     console.log($val);
    //     // Perform the ajax query
    //     $.ajax({
    //         url:"/comment/delete",
    //         method:"GET",
    //         data:{comment:val},
    //         success: function(data) {
    //             $("#post-form").append(data);
    //         },
    //         error: function(data) {
    //             errorPrompt("Error loading new image input!");
    //             // console.log(data);
    //         }
    //     });
    // })

 });
