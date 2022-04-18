var yoff = 0;
var c;

function setup() {
	createCanvas(windowWidth, windowHeight);
	colorMode(HSB, 360, 100, 100);
	c = 0;
}

function draw() {
	background(50);
	translate(width / 2, height / 2);

	stroke(255);
	fill(c, 80, 100);
	c += 1;
	c = c%360;
	strokeWeight(1);

	var da = PI / 200;
	var dx = 0.05;

	var xoff = 0;
	beginShape();
	for (var a = 0; a <= TWO_PI; a += da) {

		var n = noise(xoff, yoff);
		var r = sin(2 * a) * map(n, 0, 1, 50, 300);
		var x = r * cos(a);
		var y = r * sin(a);
		if (a < PI) {
			xoff += dx;
		} else {
			xoff -= dx;
		}

		vertex(x, y);
		
	}
	
	endShape();

	yoff += 0.01;
}

