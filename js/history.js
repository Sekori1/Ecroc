var canvas = document.querySelector('.graphCanvas');
var width = canvas.width = 1920;
var height = canvas.height = 1080;

var ctx = canvas.getContext('2d');
var graph = document.getElementById('graph');

var h = graph.dataset.history.split(',');
var historyValue = [];

var maxValue = 0;

var dayDiff = 0;
var dNow = new Date(Date.now());
var dayNow = dNow.getDay(); 

if(h.length > 7){
    var hsd = h[7];
    var hsds = hsd.split("/");
    
    var historyDate = new Date( parseInt(hsds[2]), (parseInt(hsds[1])-1), parseInt(hsds[0]) );

    var milliDiff = dNow - historyDate;
    var dayDiff = (milliDiff - milliDiff % 86400000) / 86400000;
}

for (let index = 0; index < 7; index++) {
    if(h.length > index){
        historyValue[index] = parseInt(h[index]);
        if(historyValue[index] > maxValue && (index - dayDiff) >= 0){ /* On regarde si la valeur est plus grande que la derniere valeur max trouvé et 
                                                                        on verifie si la valeur sera affiché apres le décalage créer par les jours de retard */
            maxValue = historyValue[index];
        }
    }else{
        historyValue[index] = 0;
    }
}

var graphMax = document.getElementById('graphMax').innerHTML = maxValue + "g";
var space = (width / 7);
var rectWidth = 70;
var maxRectHeight = height * 0.85;
var days = ['L','M','M','J','V','S','D'];
for (let index = 0; index < 7; index++) {
    ctx.fillStyle = '#B83A1B';
    var a =((space-rectWidth) /2 + space * index); 
    let realIndex = index + dayDiff;
    if(realIndex < 7){
        var rectHeight = (historyValue[realIndex] / maxValue) * maxRectHeight;
        var lineBottom = maxRectHeight - rectHeight;
        ctx.fillRect(a, height - maxRectHeight + lineBottom, rectWidth, rectHeight);
    }
    var dayIndex = (dayNow + index) % 7;
    $( ("#j" + (7 - index)) ).html(days[dayIndex]);
}

