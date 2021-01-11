
$(".delete_link").click(function(){

return confirm("Are you sure you want to delete it");

});


$("#selectAll").click(function(){
    $("input[type=checkbox]").prop('checked', $(this).prop('checked'));

});
