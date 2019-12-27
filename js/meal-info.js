const DAYS_NAME = ["Dimanche","Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi"];

var page = 0;
var loadedPage = 0;

function Meal(hour, weight) {
    this.hour = hour;
    this.weight = weight;
}

var currentDate = new Date(Date.now());

var values = new Array(7);

for (let index = 0; index < 7; index++) {
    values[index] = new Array();
}

$(document).ready(function(){


    var calendar = document.getElementById('meal-info-container');
    var daysMealsStr = calendar.dataset.meals.split(',');
    var dayAmount = 0;

    for (const dayMealsStr of daysMealsStr) {
        meals = dayMealsStr.split('|');
        for (const meal of meals) {
            elmt = meal.split(":");
            if(elmt.length > 1){
              values[dayAmount].push( new Meal(parseInt(elmt[0]), parseInt(elmt[1]) ));
            }
        }
        dayAmount++;
    }

    for (var i = 0; i < 7; i++) {
        createMeal(i);
    }

    $("#before-meal-button").click(function(){
        beforeDay();
    })

    $("#after-meal-button").click(function(){
        nextDay();
    })
})

function nextDay(){
    page++;
    if(page >= 7){
      page = 0;
    }
    updateCssValue();
}

function beforeDay(){
    page--;
    if(page < 0){
      page = 6;
    }
    updateCssValue();
}

function updateCssValue(){
    $(".meal-displayer-container").css("transform","translateY(" + (page*100*(-1)) +"%)");
    $(".day-displayer-container").css("transform","translateX(" + (page*100*(-1)) +"%)");
}

function createMeal(next){
    console.log(currentDate);
    nextDate = new Date( ( currentDate.getTime() + (86400000*next) ) );
    console.log(nextDate);
    dayNumber = nextDate.getDay();
    dateNumber = nextDate.getDate();
    monthNumber = nextDate.getMonth();
    var html = [];
    var td = (dayNumber - 1);
    if(td < 0)td += 7;
    for (let index = 0; index < values[td].length; index++) {
        meal = values[td][index];
        html.push("<div class=\"meal\"><h4 class=\"food-amount\">" + meal.weight + "g<h4><p class=\"food-hour\">" + getHourFormat(meal.hour) + "</p></div>");
    }

    $(".meal-displayer-container").append(
        "<div class=\"meal-displayer\">" +
            html.join("") +
        "</div>"
    );

    $(".day-displayer-container").append(
        "<p class=\"day-displayer\">" + DAYS_NAME[dayNumber] + "</p>"
    );
}

function getHourFormat(intHour){
    var hour = intHour.toString();
    var max = hour.length - 1;
    if(max < 3){
        max = max + 1;
        hour =  "0" + hour;
    }
    return (hour[max - 3] + hour[max - 2] + "h" + hour[max-1] + hour[max]);
}
