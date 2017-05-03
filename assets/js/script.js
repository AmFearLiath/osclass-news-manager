 $(document).ready(function(){ 
    var itemWidth = $("#news_wrapper").width();                
    var itemHeight = 0;

    $("#news_wrapper").children().each(function(){
        itemHeight = itemHeight + $(this).outerHeight(true) - 20;
    });

    if (itemHeight > 200) {
        $('#news_wrapper').bxSlider({
            mode: 'vertical',
            autoControls: true,
            ticker: true,
            useCSS: false,
            tickerHover: true,
            minSlides: 1,
            maxSlides: 3,
            speed: 15000,
            adaptiveHeight: false,
            slideMargin: 0,
            slideWidth: itemWidth
        });
    }
 });