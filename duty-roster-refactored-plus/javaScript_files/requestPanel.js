let request = document.getElementById('requestB');
request.addEventListener('click', function(e){
    e.preventDefault();
    document.getElementById('requestWraper').setAttribute('style', 'transition:2s;left:0px;');
    document.getElementById('cross').addEventListener('click', function(e){
        e.preventDefault();
        document.getElementById('requestWraper').setAttribute('style', 'transition:2s;left:-500px;');
    });
});