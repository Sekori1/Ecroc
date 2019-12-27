$(".weight").focusout(function() {
  var content = $(this).val();
  var v = document.getElementById("weight").validity.typeMismatch;
  var d = document.getElementById("weight").value
  console.log(content + ": " + v + " " + d)
})

$(".mealDayItem").click(function(){
  var elmt = $(this);
  toggleDaySelection(elmt);
})

$('#allDays').click(function() {
    if($(this).is(':checked')) {
        setAllDaySelection();
    } else {
        removeAllDaySelection();
    }
});

function toggleDaySelection(elmt) {
  elmt.toggleClass("active");
  var active = elmt.hasClass("active");
  elmt.find("input").val(active);
}

function setAllDaySelection() {
  var elmt = $(".mealDayItem");
  elmt.addClass("active");
  var active = elmt.hasClass("active");
  elmt.find("input").val(active);
}

function removeAllDaySelection() {
  var elmt = $(".mealDayItem");
  elmt.removeClass("active");
  var active = elmt.hasClass("active");
  elmt.find("input").val(active);
}

/* Delete Systeme */


$("#deleteButton").click(function(event){
  if($(this).hasClass("active")){
    deleteSelectedMeal();
  }else{
    event.preventDefault();
    $(this).addClass("active");
    $("#cancelButton").removeClass("hide");
    $("#deleteCounter").removeClass("hide");
    $("#mealCalendar").addClass("deleteProcess");
    $("#calendarHeader").find(".info").addClass("active");
  }
})

$("#cancelButton").click(function(){
  $("#deleteButton").removeClass("active");
  $(this).addClass("hide");
  $("#deleteCounter").addClass("hide");
  $("#mealCalendar").removeClass("deleteProcess");
  $("#calendarHeader").find(".info").removeClass("active");
})

$(".mealCard:not(.empty)").click(function(){
  if($("#mealCalendar").hasClass("deleteProcess")){
    $(this).toggleClass("active");
    var c = $(".mealCard.active").length;
    console.log("test " + c)
    $("#deleteCounter").find("p").text(c);
  }
})
