(function StopWatch(){

    let startTimeTxt = document.getElementById('startTimeTxt');
    let runningTimeTxt = document.getElementById('runningTimeTxt');
    let totalTimeTxt = document.getElementById('totalTimeTxt');

    let startB = document.getElementById('startB').addEventListener('click',function(e){
        e.preventDefault();
        start_End_runing(true);    
    });
    let endB = document.getElementById('endB').addEventListener('click',function(e){
        e.preventDefault();
        start_End_runing(false);  
    
    });
    
    let reset = document.getElementById('resetB').addEventListener('click', function(e){
        e.preventDefault();
        reset_watch();
        
    });

    let startTime, totalTime, runner, watchOn = false, Startdate,  secounds = 0, minutes= 0, hours = 0, miliSeconds;

    this.setDate = function(){
        let currentDateTime = new Date();
        let s = currentDateTime.getSeconds();
        let m = currentDateTime.getMinutes();
        let h = currentDateTime.getHours();
        if(secounds < 0.10) 
        Startdate = `${h}:${m}:${s}`;
    }

    this.start_End_runing = function(onOff){
        if(onOff === true){
            if(watchOn === true){
            throw  new Error("Stop Watch Is Running!");
            return;
        }
        this.run_watch();
        }else if(onOff === false){
            this.stop_watch();
        }
    }

    this.run_watch = function(){
        this.setDate();
            watchOn = true;
            startTimeTxt.innerHTML = Startdate;
            this.runner = setInterval(function(){
                secounds += 0.10;
                if(secounds > 59){
                    minutes++;
                    secounds = 0;
                }
                if(minutes === 59 && secounds === 59)
                    hours++; 
                runningTimeTxt.innerHTML = `${hours}:${minutes > 10 ? '':'0'}${minutes}:${secounds.toFixed(2)}`;
                totalTime = `${hours}:${minutes > 10 ? '':'0'}${minutes}:${secounds.toFixed(2)}`;
            },100)
    }

    this.stop_watch = function(){
        clearInterval(this.runner);
            totalTimeTxt.innerHTML = totalTime;
            watchOn = false;
    }

    this.reset_watch = function(){

        start_End_runing(false);
        secounds = 0;
        totalTime = null;
        startTimeTxt.innerHTML = '';
        totalTimeTxt.innerHTML = '';
        runningTimeTxt.innerHTML = '';
    }

    Object.defineProperty(
    this, 'Startdate',
     this, 'watchOn', this, 'startTimeTxt',
      this, 'secounds', this, 'totalTimeTxt',
      this, 'runningTimeTxt',this, 'miliSeconds',
      this, 'minutes', this, 'hours', this, 'totaltime',{
        get: function(){
            return totaltime;
        },

        get: function(){
            return secounds;
        },

        get: function(){
            return minutes;
        },

        get: function(){
            return hours;
        },

        get: function(){
            return runningTimeTxt;
        },

        get: function(){
            return totalTimeTxt;
        },


        set: function(){
            return secounds;
        },

        get: function(){
            return startTimeTxt;
        },

        set: function(){
            return startTimeTxt;
        },

        get: function(){
            return Startdate;
        },
        
        set: function(){
            return Startdate;
        },
        

        get: function(){
            return watchOn;
        },
})

})();