var block = document.getElementById("block");
var hole = document.getElementById("hole");
var character = document.getElementById("character");
var jumping = 0;
var counter = 0;

// Vent til DOM'en er lastet før eventlisner legges til
document.addEventListener('DOMContentLoaded', function() {
    hole.addEventListener('animationiteration', () => {
        // Generer en tilfeldig høyde for hullet
        var random = -((Math.random()*300)+150);
        hole.style.top = random + "px";
        counter++;
        // Oppdater poengsummen i HTML
        let scoreDisplay = document.getElementById("score");
        scoreDisplay.innerHTML = "Score: " + counter;
        console.log(counter);
    });
});

// Funksjon som håndterer spillogikk
setInterval(function(){
    // Hent gjeldende topposisjon for karakteren
    var characterTop = parseInt(window.getComputedStyle(character).getPropertyValue("top"));
    
    // Hvis ikke i hopp, beveg karakteren nedover
    if(jumping==0){
        character.style.top = (characterTop+3)+"px";
    }

    // Hent venstre posisjon for blokken og topposisjon for hullet
    var blockLeft = parseInt(window.getComputedStyle(block).getPropertyValue("left"));
    var holeTop = parseInt(window.getComputedStyle(hole).getPropertyValue("top"));
    
    // Beregn karakterens virtuelle topposisjon basert på skjermstørrelsen
    var cTop = -(500-characterTop);

    // Sjekk for kollisjon med bakken eller blokken/hullet
    if((characterTop>480)||((blockLeft<20)&&(blockLeft>-50)&&((cTop<holeTop)||(cTop>holeTop+130)))){
        // Hvis spillet er over, vis en bekreftelsesdialog med poengsum
        if(confirm("Spill over. Poengsum: "+(counter) + " Trykk OK for å lagre poeng eller Avbryt for å spille igjen")){
            // Send AJAX-forespørsel for å oppdatere poengsummen i databasen
            var xhr = new XMLHttpRequest();
            var url = 'score.php'; 
            var params = 'score=' + (counter);

            xhr.open('POST', url, true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Håndter responsen om nødvendig
                    console.log(xhr.responseText);
                }
            };

            xhr.send(params);
        } else {
            // Hvis brukeren velger å spille igjen, last inn siden på nytt og tilbakestill variabler
            window.location.reload();
            character.style.top = 100 + "px";
            counter = 0;
        }
    }
},10);

// Funksjon for å håndtere hopp
function jump(){
    jumping = 1;
    let jumpCount = 0;
    // Sett opp intervall for hoppanimasjon
    var jumpInterval = setInterval(function(){
        var characterTop = parseInt(window.getComputedStyle(character).getPropertyValue("top"));
        // Hvis karakteren ikke er for høyt oppe og hoppet ikke er fullført
        if((characterTop>6)&&(jumpCount<15)){
            character.style.top = (characterTop-5)+"px";
        }
        // Avslutt hoppet etter en viss tidsperiode
        if(jumpCount>20){
            clearInterval(jumpInterval);
            jumping=0;
            jumpCount=0;
        }
        jumpCount++;
    },10);
}
