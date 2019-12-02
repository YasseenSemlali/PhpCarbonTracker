document.addEventListener("DOMContentLoaded",init);

function init(){
    //alert("Hello World!!");
    var dates = new Array();
    var emissions = new Array();
    var origin = document.getElementById('origin')
    origin.addEventListener('change',handleOrigin);
    var destination = document.getElementById('destination')
    destination.addEventListener('change',handleDestination)
   
    drawChart();
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
    
    function drawChart(){
    getTableData();

     const svg = document.querySelector('.line-chart')
     new chartXkcd.Line(svg, {
        title: 'Carbon Emission Chart',
        xLabel: 'Dates',
        yLabel: 'CO2 Emitted',
        data: {
          labels:dates,
       datasets: [{
            label: 'Carbon Emitted',
            data:emissions,
          }]
          },
         options: {}
        });
    }
    
   function getTableData(){ 
    var oTable = document.getElementById('tripTable');

    //gets rows of table
    var rowLength = oTable.rows.length;

    //loops through rows    
    for (i = 0; i < rowLength; i++){

      //gets cells of current row  
       var oCells = oTable.rows.item(i).cells;

       //gets amount of cells of current row
       var cellLength = oCells.length;

       //loops through each cell in current row
       for(var j = 0; j < cellLength; j++){

              // get your cell info here

              var cellVal = oCells.item(j).innerHTML;
             
              if(i>= 2 && j == 3){
                  //add time
                   //  alert(cellVal + "is date");
                  dates.push(cellVal);
              }else if(i>= 2 && j == 5){
                    //alert(cellVal + "is Emission");
                  //add co2 emission
                  emissions.push(cellVal)
              }
             
           }
    }
   }
}
