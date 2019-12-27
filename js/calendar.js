/*
    DAYS[X][Y]:
        X: Jour de la semaine
        Y: Numero du repas
*/
var DAYS = new Array();

/*
    Objet repas
        day: Le jour de distribution
        hour: L'heure de distribution
        weight: La quantité distribué
*/
function MealData(day, hour, weight) {
    this.day = day;
    this.hour = hour;
    this.weight = weight;
}

var calendar = document.getElementById('mealCalendar');//On recupere les données depuis la page HTML
var daysMealsStr = calendar.dataset.meals.split(',');//On decoupe les données separé par des virgules


/***************************************************
On transforme les données text en données objet
*/
var dayAmount = 0;
var value = [];//List d'objet repas
for (const dayMealsStr of daysMealsStr) {
    meals = dayMealsStr.split('|');
    for (const meal of meals) {
        elmt = meal.split(":");
        if(elmt.length > 1){
          value.push( new MealData(dayAmount, elmt[0], parseInt(elmt[1]) ));
        }
    }
    dayAmount++;
}

var rowAmount = 1; /* Nombre max de ligne du calendrier */
for (var data of value) {
    console.log(data);
    var day = data.day;
    var hour = data.hour;

    var insert = false;
    var rMeal = DAYS[day];
    if(rMeal == null){
        rMeal = new Array();
    }

    for (let i = 0; i < rMeal.length; i++) {
        const rHour = rMeal[i].hour;
        if(rHour >= hour){
            insert = true;
            if(rHour != hour){
                rMeal.splice(i, 0, data);
            }
            break;
        }
    }
    if(!insert){
        rMeal.push(data);
    }
    DAYS[day] = rMeal;
    if(rMeal.length > rowAmount)rowAmount = rMeal.length;//On met à jour le nombre max de ligne du calendrier
}

/*********************************************************/

updateRows(rowAmount);


/*
    Permet de generer le code html pour une carte repas

    mealIndex: Index du repas
    dayIndex: Index du jour de la semaine (0 - 6)
*/
function getMealCard(mealIndex, dayIndex){
    var hour = "";
    var weight = "";
    var meals = DAYS[dayIndex];
    if(meals != null){
        meal = meals[mealIndex];
        if(meal != null){
            hour = getHourFormat(meal.hour);
            weight = meal.weight + "g";
            return "<div class=\"mealCard\" data-meal=\"" + dayIndex +":" + mealIndex + "\"> <p class=\"mealWeight\">" + weight + "</p> <p class=\"mealHour\">" + hour + "</p> </div>"
        }
    }
    return "<div class=\"mealCard empty\"></div>"
}

/*
    Permet de metre à jour les lignes des repas

    mealNumber: Nombre de ligne de repas
*/

function updateRows(mealNumber){
    var mealIndex = 0;
    while(mealIndex < mealNumber){
        $( ".calendarGrid" ).append(
            "<div class=\"mealRow\">" +
                "<div class=\"mealNumber\">REPAS " + (mealIndex+1) + "</div>" +

                getMealCard(mealIndex, 0) +
                getMealCard(mealIndex, 1) +
                getMealCard(mealIndex, 2) +
                getMealCard(mealIndex, 3) +
                getMealCard(mealIndex, 4) +
                getMealCard(mealIndex, 5) +
                getMealCard(mealIndex, 6) +

            "</div>"
        );
        mealIndex++;
    }
}


function getHourFormat(hour){
    console.log("H: " + hour);
    var max = hour.length - 1;
    console.log("M: " + max)
    if(max < 3){
        console.log("add")
        max = max + 1;
        hour =  "0" + hour;
    }

    var t = (hour[max - 3] + hour[max - 2] + "h" + hour[max-1] + hour[max]);

    console.log("F: " + t);
    return t;
}

/* ADD MEAL BUTTON */

$("#mealAddButton").click(function(){
    $("#mask").addClass("active");
    $("#mealAdd").addClass("active");
});

$("#mask").click(function(){
    $("#mask").removeClass("active");
    $("#mealAdd").removeClass("active");
});


function deleteSelectedMeal(){
    var cards = $(".mealCard.active");
    txtArray = new Array(7);
    var txt = "";

    console.log(cards);

    cards.each(function(index){
        var card = $(this);
        var data = card.data("meal").split(':');
        console.log(data);
        if(data.length == 2){
            var dayIndex = data[0];
            var mealIndex = data[1];
            console.log(DAYS);
            console.log("Card of Index: " + dayIndex +  " and MealIndex: " + mealIndex);
            console.log(DAYS[dayIndex][mealIndex]);
            var meal = (DAYS[dayIndex][mealIndex]);
            if(txtArray[dayIndex] == null){
                txtArray[dayIndex] = "";
            }
            txtArray[dayIndex] += (meal.hour) + ":";
            console.log("text Array")
            console.log(txtArray);
        }
    })

    for (var textElmt of txtArray) {
        console.log(textElmt);
        if(textElmt == null){
            textElmt = "";
        }
        txt += textElmt + "/";
    }

    $("#deleteDataImput").val(txt);
    console.log("TXT=" + txt)

}
