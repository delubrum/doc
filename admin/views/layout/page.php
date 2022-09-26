<style>

#container {
    text-align: center;
    margin-top:16%;
}

#container img{
    display:inline-block;
    margin: 70px;
    
}

@media screen and (max-width:1023px) {
    #container {
margin-top:0%;

}  
}

#container img{
    margin: 50px;  
}
</style>

<div id="container">
<img src="middlewares/barcode.php?text='0000001'&size=50&codetype=Code39&print=true"/>
</div>