document.addEventListener("DOMContentLoaded",init);

function init(){
    //alert("Hello World!!");
    var origin = document.getElementById('origin')
    origin.addEventListener('change',handleOrigin);
    var destination = document.getElementById('destination')
    destination.addEventListener('change',handleDestination)
    
    function handleOrigin(event){
        if(origin.value == "other"){
            createOriginInput();
        }else{
              var parentDiv = document.getElementById('fillOrigin');
            removeAllnode(parentDiv)
        }
    }
    
    function handleDestination(){
        if(destination.value == "other"){
            createDestiantionInput();
        }else{
            var parentDiv = document.getElementById('fillDest');
            removeAllnode(parentDiv);
        }
    }
    
    
    function createOriginInput(){
        
        var parentDiv = document.getElementById('fillOrigin');
       removeAllnode(parentDiv);
        var originLabel = document.createElement("Label");
        originLabel.setAttribute("name",'origin');
        originLabel.innerHTML = "Address";
        
        var originTxt = document.createElement('input');
        originTxt.setAttribute("type","text");
        originTxt.setAttribute("name",'start');
        
        parentDiv.appendChild(originLabel);
        parentDiv.appendChild(originTxt)

        
    }
     
    function createDestiantionInput(){
        
        var parentDiv = document.getElementById('fillDest');
        removeAllnode(parentDiv);
        var originLabel = document.createElement("Label");
        originLabel.innerHTML = "Address";
        
        var originTxt = document.createElement('input');
        originTxt.setAttribute("type","text");
        originTxt.setAttribute("name",'destination');
        
        parentDiv.appendChild(originLabel);
        parentDiv.appendChild(originTxt)

        
    }
    
    function removeAllnode(parent){
          while(parent.hasChildNodes()){
            parent.removeChild(parent.lastChild);
        }
    }
}
