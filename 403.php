<style>

html,body{
    margin:0;
    padding:0;
    display:flex;
    justify-content:center;
    align-items:center;
    background-color:black;
    font-family:"Quicksand", sans-serif;

}

#container_anim{
    position:relative;
    width:100%;
    height:70%;
}

#key{
    position:absolute;
    top:77%;
    left:-33%;
}

#text{
  font-size:4rem;
  position:absolute;
  top:55%;
  width:100%;
  text-align:center;
  color:white;
}

#credit{
    position:absolute;
    bottom:0;
    width:100%;
    text-align:center;
    bottom:
}

a{
    color: rgb(115,102,102);
}
</style>

<div id="container_anim">
        <div id="lock" class="key-container">
            <!-- Generator: Gravit.io -->
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="isolation:isolate" viewBox="317.286 -217 248 354" width="248" height="354"><g><path d="M 354.586 -43 L 549.986 -43 C 558.43 -43 565.286 -36.144 565.286 -27.7 L 565.286 121.7 C 565.286 130.144 558.43 137 549.986 137 L 354.586 137 C 346.141 137 339.286 130.144 339.286 121.7 L 339.286 -27.7 C 339.286 -36.144 346.141 -43 354.586 -43 Z" style="stroke:none;fill:#2D5391;stroke-miterlimit:10;"/><g transform="matrix(-1,0,0,-1,543.786,70)"><text transform="matrix(1,0,0,1,0,234)" style="font-family:'Quicksand';font-weight:700;font-size:234px;font-style:normal;fill:#4a4444;stroke:none;">U</text></g><g transform="matrix(-1,0,0,-1,530.786,65)"><text transform="matrix(1,0,0,1,0,234)" style="font-family:'Quicksand';font-weight:700;font-size:234px;font-style:normal;fill:#8e8383;stroke:none;">U</text></g><path d="M 343.586 -52 L 538.986 -52 C 547.43 -52 554.286 -45.144 554.286 -36.7 L 554.286 112.7 C 554.286 121.144 547.43 128 538.986 128 L 343.586 128 C 335.141 128 328.286 121.144 328.286 112.7 L 328.286 -36.7 C 328.286 -45.144 335.141 -52 343.586 -52 Z" style="stroke:none;fill:#4A86E8;stroke-miterlimit:10;"/><g><circle vector-effect="non-scaling-stroke" cx="441.28571428571433" cy="63.46153846153848" r="10.461538461538453" fill="rgb(0,0,0)"/><rect x="436.055" y="66.538" width="10.462" height="34.462" transform="matrix(1,0,0,1,0,0)" fill="rgb(0,0,0)"/></g></g></svg>
        </div>
    </div>

    <p id="text">403 FORBIDDEN</p>

    

    <script src="https://github.com/michaelvillar/dynamics.js/releases/download/1.1.5/dynamics.min.js
"></script>



    <script>
        var lock = document.querySelector('#lock');
var key = document.querySelector('#key');


function keyAnimate(){
    dynamics.animate(key, {
        translateX: 33
    }, {
        type:dynamics.easeInOut,
        duration:500,
        complete:lockAnimate
    })
}


function lockAnimate(){
    dynamics.animate(lock, {
        rotateZ:-5,
        scale:0.9
        }, {
            type:dynamics.bounce,
            duration:3000,
            complete:keyAnimate
        })
}


setInterval(keyAnimate, 3000);
    </script>
