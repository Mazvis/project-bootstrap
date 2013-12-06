(function($){

    $('.toggle-sidebar').click(function(){
        $($(this).attr('data-target')).toggleClass("active");
    });

    $(".contact-search input").keyup(function(){
        var input = $(this);

        if( input.val() == "" ) {
            $('a[href="#contact-search"]').parent().addClass("hidden");
            $('#sidebarTabs1 a[href="#contacts"]').tab('show');
        } else {
            $('a[href="#contact-search"]').parent().removeClass("hidden");
            $('#sidebarTabs1 a[href="#contact-search"]').tab('show');
        }
    });

    /**
     * for user status
     *
     * @type {*|jQuery|HTMLElement}
     */
    var statusSelectContainer = $(".user-status .online-status");
    var listElements = "";
    $("select option", statusSelectContainer).each(function(){
        listElements += "<li><i class='icon icon-"+$(this).text()+"'></i>"+$(this).text()+"</li>";
    });

    var styledStatusSelect = "<div class='custom-status-select'><span class='selected'><i class='icon icon-online'></i> </span><ul>"+listElements+"</ul></div>";
    statusSelectContainer.append(styledStatusSelect);

    $(".custom-status-select", statusSelectContainer).not(".open").click(function(){
        $(this).addClass("open");
    });

    $("li", statusSelectContainer).click(function(event){
        event.stopPropagation();
        $(".custom-status-select").removeClass("open");
        $(".online-status select option:selected").prop('selected', false);
        $(".online-status select option").eq($(this).index()).prop('selected', true);
        $(".online-status select").trigger("change");
    });
    $(".online-status select").change(function(){
        $(".custom-status-select .selected i").attr("class", "icon icon-"+$(".online-status select option:selected").text());
    })

    //for user panel drop down button
    var isClick = false;
    $(".dropdown").click(function(){
        if(!isClick){
            $(this).addClass("open");
            isClick = true;
        }
        else{
            $(this).removeClass("open");
            isClick = false;
        }
    });

})(jQuery);
