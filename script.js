

var block = document.getElementById("block");
var hole = document.getElementById("hole");
var character = document.getElementById("character");
var jumping = 0;
var counter = 0;

document.addEventListener('DOMContentLoaded', function() {
    hole.addEventListener('animationiteration', () => {
        var random = -((Math.random()*300)+150);
        hole.style.top = random + "px";
        counter++;
        let scoreDisplay = document.getElementById("score");
        scoreDisplay.innerHTML = "Score: " + counter;
        console.log(counter)
    });
});

setInterval(function(){
    var characterTop = parseInt(window.getComputedStyle(character).getPropertyValue("top"));
    if(jumping==0){
        character.style.top = (characterTop+3)+"px";
    }
    var blockLeft = parseInt(window.getComputedStyle(block).getPropertyValue("left"));
    var holeTop = parseInt(window.getComputedStyle(hole).getPropertyValue("top"));
    var cTop = -(500-characterTop);
    if((characterTop>480)||((blockLeft<20)&&(blockLeft>-50)&&((cTop<holeTop)||(cTop>holeTop+130)))){
        if(confirm("Game over. Score: "+(counter) + " trykk OK for å lagre score or Cancel for å spille igjenn")){
            //put code for PHP database update or whatever
            // Send AJAX request to update score in the database
            var xhr = new XMLHttpRequest();
            var url = 'score.php'; // Replace with your PHP script URL
            var params = 'score=' + (counter);

            xhr.open('POST', url, true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Handle the response if needed
                    console.log(xhr.responseText);
                }
            };

            xhr.send(params);
        } else{
            window.location.reload()
            character.style.top = 100 + "px";
            counter=0;
        }
    }
},10);



function jump(){
    jumping = 1;
    let jumpCount = 0;
    var jumpInterval = setInterval(function(){
        var characterTop = parseInt(window.getComputedStyle(character).getPropertyValue("top"));
        if((characterTop>6)&&(jumpCount<15)){
            character.style.top = (characterTop-5)+"px";
        }
        if(jumpCount>20){
            clearInterval(jumpInterval);
            jumping=0;
            jumpCount=0;
        }
        jumpCount++;
    },10);
}