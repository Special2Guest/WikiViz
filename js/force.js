//Width and height
var w = 500;
var h = 300;

//Original data
/*var dataset = {
	nodes: [
		{ name: "Center", rad: 5 },
		{ name: "Link 1", rad: 5 },
		{ name: "Link 2", rad: 5 },
		{ name: "Link 3", rad: 5 },
		{ name: "Link 4", rad: 5 },
		{ name: "Link 5", rad: 5 },
		{ name: "Link 6", rad: 5 },
		{ name: "Link 7", rad: 5 },
		{ name: "Link 8", rad: 5 },
		{ name: "Link 9", rad: 5 }
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
};*/

var dataset = <?php echo $linkData; ?>;

//Initialize a default force layout, using the nodes and edges in dataset
var force = d3.layout.force()
					 .nodes(dataset.nodes)
					 .links(dataset.edges)
					 .size([w, h])
					 .linkDistance([50])
					 .charge([-100])
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

//Create nodes as circles
var nodes = svg.selectAll("circle")
	.data(dataset.nodes)
	.enter()
	.append("circle")
	.attr("r", function(d) { return d.rad })
	.style("fill", function(d, i) {
		return colors(i);
	})
	.call(force.drag);

//Every time the simulation "ticks", this will be called
force.on("tick", function() {

	edges.attr("x1", function(d) { return d.source.x; })
		 .attr("y1", function(d) { return d.source.y; })
		 .attr("x2", function(d) { return d.target.x; })
		 .attr("y2", function(d) { return d.target.y; });

	nodes.attr("cx", function(d) { return d.x; })
		 .attr("cy", function(d) { return d.y; });

});

