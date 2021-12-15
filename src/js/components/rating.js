function rateSystem( className, obj, fnc=function(){} ) {
    /* window.myStarCollection.push(className); */
    for( let i=0; i<obj.length; i++ ) {
        document.getElementsByClassName(className)[i].style.width = (obj[i].rating*obj[i].starSize) + "px";
        document.getElementsByClassName(className)[i].style.height = obj[i].starSize + "px";
        document.getElementsByClassName(className)[i].style.backgroundSize=obj[i].starSize + "px";
        document.getElementsByClassName(className)[i].style.backgroundImage = "url('" + obj[i].starImage + "')" ;
        document.getElementsByClassName(className)[i].style.backgroundRepeat="repeat-x";
        document.getElementsByClassName(className)[i].parentElement.style.width = (parseInt(obj[i].starSize)*parseInt(obj[i].maxRating) ) + "px";
        document.getElementsByClassName(className)[i].parentElement.style.maxWidth = (parseInt(obj[i].starSize)*parseInt(obj[i].maxRating) ) + "px";
        document.getElementsByClassName(className)[i].parentElement.style.height = parseInt(obj[i].starSize)+"px";

        if ( obj[i].minRating ) {
            document.getElementsByClassName(className)[i].style.minWidth = (obj[i].minRating*obj[i].starSize) + "px";
        } else {
            document.getElementsByClassName(className)[i].style.minWidth = "0px";
        }

        if ( obj[i].backgroundStarImage ) {
            document.getElementsByClassName(className)[i].parentElement.style.backgroundSize=obj[i].starSize + "px";
            document.getElementsByClassName(className)[i].parentElement.style.backgroundRepeat="repeat-x";
            document.getElementsByClassName(className)[i].parentElement.style.backgroundImage = "url('" + obj[i].backgroundStarImage + "')" ;
        }

        if ( obj[i].emptyStarImage ) {
            document.getElementsByClassName(className)[i].innerHTML = '<div class="emptyStarRating"></div>';
            document.getElementsByClassName(className)[i].getElementsByClassName("emptyStarRating")[0].style.backgroundSize = parseInt(obj[i].starSize) + "px";
            document.getElementsByClassName(className)[i].getElementsByClassName("emptyStarRating")[0].style.backgroundImage = "url('" + obj[i].emptyStarImage + "')" ;
            document.getElementsByClassName(className)[i].getElementsByClassName("emptyStarRating")[0].style.backgroundRepeat="repeat-x";
            document.getElementsByClassName(className)[i].getElementsByClassName("emptyStarRating")[0].style.width = (parseInt(obj[i].starSize)*parseInt(obj[i].maxRating) ) + "px";
            document.getElementsByClassName(className)[i].getElementsByClassName("emptyStarRating")[0].style.height = parseInt(obj[i].starSize)+"px";
        }

        document.getElementsByClassName(className)[i].style.maxWidth = obj[i].starSize*obj[i].maxRating + "px";
        document.getElementsByClassName(className)[i].dataset.rating = obj[i].rating;
        document.getElementsByClassName(className)[i].dataset.step = obj[i].step;
    }
}

window.addEventListener( 'load', function() {
    var settings =[
        {
            "rating":"3.5",
            "maxRating":"5",
            "minRating":"0.1",
            "starImage":"./assets/images/rating-background.png",
            "emptyStarImage":"./assets/images/rating-circle.png",
            "starSize":"18",
            "step":"0.1"
        },
        {
            "rating":"1.5",
            "maxRating":"5",
            "minRating":"0.1",
            "starImage":"./assets/images/rating-background.png",
            "emptyStarImage":"./assets/images/rating-circle.png",
            "starSize":"18",
            "step":"0.1"
        }
    ];
    rateSystem( 'vtr__rating', settings );
});
