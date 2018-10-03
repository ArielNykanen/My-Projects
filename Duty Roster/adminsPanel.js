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