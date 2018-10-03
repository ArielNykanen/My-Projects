let loading = (function(){
    if(localStorage.getItem('counter')){
        let temp = localStorage.getItem('counter');
        temp = JSON.parse(temp);
        var counter = temp;
    }else{
        var counter = 0;
    }
    let wall = document.getElementById('loading');
    let introWall = document.getElementById('intro'); 
    introWall.innerHTML += $TEMP_intro();
    let closeIntroWall = document.getElementById('closeIntro'); 
    let modsMenue = document.getElementById('switchMod');
    let main = document.getElementById('main');
    function addEvent(){
        modsMenue.addEventListener('click', function(e){
            e.preventDefault();
            main.innerHTML = $TEMP_numberSearch();
            modsMenue.addEventListener('click', function(e){
                e.preventDefault();
                main.innerHTML = $TEMP_keySearch();
                addEvent();
            });
        });
        
    }
    addEvent();
        getNumLine = function(){
            let math = "" + Math.floor(Math.random()*2);
            for(let i = 0;i < 30;i++){
                math += Math.floor(Math.random()*2);
            }
            return math;
        }
        let inter = setInterval(function(){
            let numLine = this.getNumLine();            
            let numLine1 = this.getNumLine();            
            wall.innerHTML = `
            <span style='color:green'>${numLine}</span><br>
            <span style='color:green'>${numLine1}</span>
            `;
        },100);
        if(counter <= 0){
        
            localStorage.setItem('counter', 1);
        setTimeout(() => {
            introWall.setAttribute('style', "min-height:330px; top:0;");
        }, 500);
        closeIntroWall.addEventListener('click', function(e){
            e.preventDefault();
            introWall.setAttribute('style', "min-height:330px; top:-400;");
            setTimeout(() => {
                introWall.setAttribute('style', "display:block;");
            },2000);
        });
    }
        return{
            inter:inter
        }
})();