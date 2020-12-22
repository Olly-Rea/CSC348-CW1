/* * * * * * * * * * * * * * * * * * * * * * * * *
 *    JQuery Global doc for Union Collective     *
 * * * * * * * * * * * * * * * * * * * * * * * * */

// get the CSRF token for JQuery AJAX
$.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
