$("#profileAddButton").click(function(){
    $("#mask").addClass("active");
    $("#profileAdd").addClass("active");   
});

$("#mask").click(function(){
    $("#mask").removeClass("active");
    $("#profileAdd").removeClass("active");   
});