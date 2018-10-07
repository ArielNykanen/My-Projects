var counter = 0;
function bgChanger(){
    if(counter === 0){
        document.body.setAttribute('style', 'transition:4s; background-image: url(images/Amain.jpg);');
    }
    if(counter === 1){
        document.body.setAttribute('style', 'transition:4s; background-image: url(images/Amain2.jpg);');    
        counter = -1;
    }
    counter++;
    setTimeout(function(){
        bgChanger();
    },10000)
}
bgChanger();


//--------Start of hide element method--------//


let displayNone_block = (function(){
let Display = {
    display : "none"
}
let hideElement = document.getElementsByClassName('hiding-elements');
if(hideElement){
    for (let index = 0; index < hideElement.length; index++) {
        let getTarget = hideElement[index].dataset.targeting;
        let gettingHided = document.getElementsByClassName(getTarget);
        hideElement[index].addEventListener('click',hide = function(){
            for (let i = 0; i < gettingHided.length; i++) {
            gettingHided[i].style.display = Display.display;
            }
            if(Display.display === "block"){
                Display.display = "none";
            }else{
                Display.display = "block";
            }
        });
    }
}

})();


let change_class = (function() {
    let Class = {
        check : false,
        class : ""
    }
    let changeClass = document.getElementsByClassName('toggle-classes');
    if (changeClass) {
        for (let index = 0; index < changeClass.length; index++) {
    let changeClass = document.getElementsByClassName('toggle-classes');
            let toggleClass = changeClass[index].dataset.toggle_class;
            
            changeClass[index].addEventListener('click', function(e) {
                changeClass[index].classList.toggle(`${toggleClass}`);
            });
        }
    }
})();


//--------END Of hide element method--------//