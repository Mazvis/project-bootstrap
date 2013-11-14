$(document).ready(function() {
    $(".navigation_left_item>a").click(function(event){
        var li = $(this).parent();
        if (li.find("ul").length > 0) {
            event.preventDefault ? event.preventDefault() : event.returnValue = false;
            li.toggleClass("open");
        }
    });
});