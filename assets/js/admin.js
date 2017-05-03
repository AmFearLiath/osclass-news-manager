$(document).ready(function(){    
    
    var fixHelper = function(e, ui) {  
      ui.children().each(function() {  
        $(this).width($(this).width());  
      });  
      return ui;  
    };
    
    var saveSort = function(data) {        
        $("#sortStatus").html('Saving sort order').fadeToggle("slow");
        
        $.ajax({
            data: data,
            type: 'POST',
            url: '/oc-content/plugins/news-manager/admin/news.php'
        }).done(function(){
            $("#sortStatus").html('Sort order saved...').delay(1500).fadeToggle("slow");    
        }).fail(function(){
            $("#sortStatus").html('Can not save new sort order').delay(1500).fadeToggle("slow");    
        });
    }
    
    $(document).on("click", ".buttonAdd", function(){
        if ($("#create").is(":visible")) {
            $("#create .widget-title h3").html('Create News').fadeIn();
            $("#create textarea").html("");
            $("#create input[name='news']").val("save");
            $("#create input[name='news_edit']").remove();
            $("#create .wysiwyg-editor").html("");
            $(this).html("<i class=\"fa fa-plus\"></i>").removeClass("btn-danger").addClass("btn-info");                
        } else {
            $(this).html("<i class=\"fa fa-minus\"></i>").removeClass("btn-info").addClass("btn-danger");    
        }
        $("#create").slideToggle("slow");
    });
    
    $(document).on("click", ".edit-news", function(){
        var id = $(this).data("id"),
            url = '/oc-content/plugins/news-manager/admin/news.php?type=edit&edit_id='+id;
        
        $.get(url, function(data) {
            var source  = $('<div>'+data+'</div>'),
                content = source.find('#create_news').html();
                
            $("#create_news").html(content);
            $("#create").slideDown(function(){
                var pos = $("#create_news").offset().top;
                
                $("#create .widget-title h3").html('Edit News').fadeIn();
                $(".news .buttonAdd").html("<i class=\"fa fa-minus\"></i>").removeClass("btn-info").addClass("btn-danger");
                
                $('html, body').stop().animate({
                    'scrollTop': $("#create_news").offset().top-140
                }, 900, 'swing', function () {
                    window.location.hash = $("#create_news");
                });   
            });
                
        });
    });
    
    $(document).on("click", ".delete-news", function(){
        var id = $(this).data("id"),
            url = '/oc-content/plugins/news-manager/admin/news.php?type=delete&delete_id='+id;
        if (confirm("You really want to delete this message? This action cannot be undone!")) {
            $.get(url, function(data) {
                $("tr#slide-"+id).remove();                
            });    
        }
    });
    
    $(document).on("click", "ul.tabs li", function(){
        var tab_id = $(this).attr('data-tab');

        $('ul.tabs li').removeClass('current');
        $('.tab-content').removeClass('current');

        $(this).addClass('current');
        $("#"+tab_id).addClass('current');
    });

    $("#news tbody").sortable({
        axis: 'y',
        placeholder: "sort-highlight",
        revert: true,
        scroll: true,
        helper: fixHelper,
        tolerance: "pointer",
        update: function (event, ui) {            
            var data    = $(this).sortable('serialize');
            saveSort('type=position&'+data);
        }
    }).disableSelection();    
    
});