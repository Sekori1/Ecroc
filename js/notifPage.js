/*$(document).ready(function(){

    var currentPage = 0;
    showPage(1);
    
    
    $(".pageSelctor").click(function() {
        $(".pageSelctor.active").removeClass("active");
        var selector = $(this);
        selector.addClass("active")
        var text = selector.text();
        var page = parseInt(text);
        console.log("---------------------------------------------------");
        console.log("CLICK ON PAGE " + page);
        console.log("---------------------------------------------------");
        showPage(page);
    });
    
    
    function showPage(page){
        var maxHeight = $(".left").innerHeight();

        console.log("Hauteur max: " + maxHeight + " pixel");

        var currentHeight = 0;
        var elementNumber = 0;
        var pageCheck = 1;

        $( ".right" ).find( ".notifBox" ).each(function( index ) {
            var elmtHeight = $( this ).outerHeight();
            elementNumber++;
            console.log("Element " + elementNumber + " \"" + $( this ).find(".notifTitle").text() + "\" : " + currentHeight + " + " + elmtHeight + " = " + (currentHeight+elmtHeight) + "px");
            currentHeight = currentHeight + elmtHeight + 10;
            
            if(currentHeight > maxHeight){
                console.log("PAGE " + pageCheck + " DEPASSE, DEBUT DE LA PAGE " + (pageCheck + 1));
                pageCheck++;
                currentHeight = elmtHeight + 10; 
            }
            if(pageCheck === page){
                console.log("Element " + elementNumber + " VISIBLE")
                $( this ).addClass("show");
            }else{
                $( this ).removeClass("show");
            }
        }); 
    }
    
});*/

var maxPageFinded = false;
var pageTest = 1;

if(!isVoidPage()){
    while(!maxPageFinded){
        maxPageFinded = isLastPage(pageTest);
        $(".pageContainer").append( "<p class=\"pageSelctor\">" + (pageTest) +"</p>" );
        pageTest++;
    }    
}else{
    $("#notifFlex").append("<p class=\"no-notif\">Vous n'avez pas de notification</p>")
}

$(".pageSelctor").first().addClass("active");

/*FORMAT DU SELECTEUR DE PAGE
    <p class="pageSelctor">2</p> 
    <p class="pageSelctor">3</p> 
    <p class="pageSelctor">4</p> 
*/
$(document).ready(function(){
    $(".pageSelctor").click(function() {
        $(".pageSelctor.active").removeClass("active");
        var selector = $(this);
        selector.addClass("active")
        var text = selector.text();
        var pageIndex = parseInt(text) - 1;
        showPage(pageIndex);
    });    
});

function showPage(newPageIndex){
    console.log("GO TO PAGE " + newPageIndex + "?");
    if(newPageIndex >= 0 && !isLastPage(newPageIndex)){
        console.log("YES! GO TO PAGE " + newPageIndex);
        var amount = newPageIndex * 100;
        $("#notifFlex").css("transform", "translateX(-" + amount + "%)")
    }
}

function isVoidPage(){
    return $("#notifFlex").children().length == 0;
}

function isLastPage(page){
    var elmt = $("#notifFlex").children();
    if(elmt.length > 0){
        var max = elmt.last().position().left;
        var width = $("#notifContainer").width() * (page-1);
        if(max <= width){
            console.log("IS THE LAST PAGE");
            return true;
        }
        return false;
    }else{
        return true;
    }
}