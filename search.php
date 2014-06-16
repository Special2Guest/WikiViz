<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
       "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Search</title>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="styles.css"> 
<script type="text/javascript" src="js/d3.min.js"></script>
<?php include 'index.php'; ?>
</head>
<body style="">
	<div id="wrapper">
	<div id="header">
		<table align="center">
			<tr>
				<td>Startseite</td><td> | </td>
				<td>Über WikiViz</td><td> | </td>
				<td>Kontakt</td><td> | </td>
				<td>Jobs</td><td> | </td>
				<td>Impressum</td>
			</tr>
		</table>
	</div>	
	<div id="leftbar">
		<div class="logo">
			<img src="" alt="Logo" />
		</div>
		<a href="wireframe.html"><div class="restart">
			<h3>Search Restart</h3>
		</div></a>
		<div class = "history">
			<h3>History des Users</h3>
		</div>
	</div>
	<div id="rightbar">
		<div id="visualisation">

			<script type="text/javascript">	
			//Width and height
			var w = 700;
			var h = 500;

			//Original data
			var dataset = {
				nodes: [
					{ name: "Center", gew: 5, lan: 10 },
					{ name: "Link 1", gew: 5, lan: 6 },
					{ name: "Link 2", gew: 2, lan: 2 },
					{ name: "Link 3", gew: 7, lan: 17 },
					{ name: "Link 4", gew: 18, lan: 4 },
					{ name: "Link 5", gew: 12, lan: 20},
					{ name: "Link 6", gew: 3, lan: 11 },
					{ name: "Link 7", gew: 26, lan: 15 },
					{ name: "Link 8", gew: 11, lan: 2 },
					{ name: "Link 9", gew: 3, lan: 9 }
				],
				edges: [
					{ source: 0, target: 1 },
					{ source: 0, target: 2 },
					{ source: 0, target: 3 },
					{ source: 0, target: 4 },
					{ source: 0, target: 5 },
					{ source: 0, target: 6 },
					{ source: 0, target: 7 },
					{ source: 0, target: 8 },
					{ source: 0, target: 9 }
					]
					};

			//Define color scale
			var color = d3.scale.linear()
						.domain([0, 60])
						.range(["yellow", "red"])

			//Initialize a default force layout, using the nodes and edges in dataset
			var force = d3.layout.force()
								 .nodes(dataset.nodes)
								 .links(dataset.edges)
								 .size([w, h])
								 .linkDistance([75])
								 .charge(-500)
								 .start();

			var colors = d3.scale.category10();

			//Create SVG element
			var svg = d3.select("#visualisation")
						.append("svg:svg")
						.attr("width", w)
						.attr("height", h);

			//Create edges as lines
			var edges = svg.selectAll("line")
				.data(dataset.edges)
				.enter()
				.append("line")
				.style("stroke", "#ccc")
				.style("stroke-width", 1);

			// Create the groups under svg
			var gnodes = svg.selectAll('g.gnode')
				.data(dataset.nodes)
				.enter()
				.append('g')
				.classed('gnode', true)
				.on("mouseover", function(d) {
      				d3.select(this).style("cursor", "pointer")
      				var g = d3.select(this); 
     				var info = g.append('text')

        			.classed('info', true)
        			.style("-webkit-touch-callout", "none")
        			.style("-webkit-user-select", "none")
        			.style("-khtml-user-select", "none")
        			.style("-moz-user-select", "none")
        			.style("-ms-user-select", "none")
        			.style("user-select", "none")

         			.text(function(d) { return d.name });
  				})
  				.on("mouseout", function() {
     			 	d3.select(this).select('text.info').remove();
     			 })
     			.on("click", function() {
     			 	var searchstring ="";
     			 	searchstring += "http://www.pandora-interactive.de/Datenviz/wikiviz/search.php?search="
     			 	var a = d3.select(this).select('text.info').text()
     			 	var b = a.split(" ");
     			 	for (i=0; i<b.length; i++) {
     			 		if (i==0) {
     			 			searchstring += b[i];
     			 		} else {
     			 			searchstring += "_";
     			 			searchstring += b[i];
     			 		}
     			 	window.location = searchstring;
     			 			
     			 	};
     			 	
     			 	console.log(searchstring);


     				}); 
 				 
				
     	

			//Create nodes as circles
			var node = gnodes.append("circle")
				.attr("class", "node")
				.attr("r", function(d) { return d.gew })
				.style("fill", function(d) { return color (d.lan) })
				//.call(force.drag)
				
			// Append the labels to each group
			//var labels = gnodes.append("text")
			//	.text(function(d) { return d.name; })
			//	.style("visibility", "hidden");

			
				

			//Every time the simulation "ticks", this will be called
			force.on("tick", function() {

				edges.attr("x1", function(d) { return d.source.x; })
					 .attr("y1", function(d) { return d.source.y; })
					 .attr("x2", function(d) { return d.target.x; })
					 .attr("y2", function(d) { return d.target.y; });


			// Translate the groups
				gnodes.attr("transform", function(d) { 
					return 'translate(' + [d.x, d.y] + ')'; 
				});  

			});
			</script>
		</div>
		<div class="wikilink">
			<?php echo "<a href='http://de.wikipedia.org/w/index.php?title=$underscoreSearch' target='_blank'>Link zur Orginal Seite</a>"; ?>
		</div>
	</div>
</body>
</html>
