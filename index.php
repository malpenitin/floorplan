<html>
	<head>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
		<script src="https://d3js.org/d3.v5.js"></script>
	</head>
    <style>
        .svg-background {
            background-image: url('images/green-tile.png');
        }
    </style>

	<title>Floor Plan Demo</title>
	<body>
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  			<a class="navbar-brand text-white">Floor Plan Demo</a>
  		</nav>
  		<div class="container-fluid">
  			<div class="row">
  				<div class="col-10" style="height:100%; background-image: url('images/plan.jpg'); background-repeat: no-repeat; background-size: 1200px 900px;">
  				  	<div class="map"></div>
  				</div>
  				<div class="col-2" style="background-color:#d4ebf2;">
  						
  				</div>
  			</div>
  		</div>

      <script>
        $(document).ready(function(){

            var mapWidth = 1200, mapHeight = 900;

            var lineData = new Array();

            var freeFormTool = true;

            var svg = d3.select('.map')
              .append('svg')
              .attr('width', mapWidth)
              .attr('height', mapHeight)
              .attr('class','svg-background');

            svg.on('mousemove', function () {
               x = d3.mouse(this)[0];
               y = d3.mouse(this)[1];  

              // console.log(x+","+y);       
            });

            svg.on("click", function() {
                var coordinate = d3.mouse(this);
                if(freeFormTool)
                    populateLineData(coordinate);

            });

            function populateLineData(coordinate)
            {
                if(lineData.length == 0)
                {
                    drawCircle(coordinate);
                }
                
                var coordinateData = {
                    "x":coordinate[0],
                    "y":coordinate[1]  
                };

                lineData.push(coordinateData);

                drawLine(lineData);
            }

            function drawLine(lineData)
            {
                var lineFunction = d3.line()
                    .x(function(d) { return d.x; })
                    .y(function(d) { return d.y; })
                    .curve(d3.curveLinear); 

                svg.append("path")
                            .attr("d", lineFunction(lineData))
                            .attr("stroke", "#00ff00")
                            .attr("stroke-width", 4)
                            .attr("fill", "none");
            }

            function drawCircle(coordinate)
            {
                svg.append("circle")
                    .attr("cx", coordinate[0])
                    .attr("cy", coordinate[1])
                    .attr("r", 10)
                    .attr("fill", "black")
                    .on("mouseover", handleCircleMouseOver)
                    .on("mouseout", handleCircleMouseOut)
                    .on("click", handleCircleClick);
            }

            function handleCircleMouseOver(d, i) {

                freeFormTool = false;

                d3.select(this)
                    .attr("r", 20)
                    .attr("fill", "orange");

            }

            function handleCircleMouseOut(d, i) {

                 freeFormTool = true;

                 d3.select(this)
                    .attr("r", 10)
                    .attr("fill", "black");
            }

            function handleCircleClick(d, i) {  // Add interactivity

                //var finalPathData = new Array();

                lineData.push(lineData[0]);

                drawLine(lineData);  

                console.log(lineData);

                d3.select(this).remove();

                lineData.length = 0;

                freeFormTool = true;

                event.stopPropagation();

            }

            


        });
      </script>
	</body>
</html>