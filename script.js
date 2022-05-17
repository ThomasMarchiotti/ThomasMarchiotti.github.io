var yoff = 0;
var c;

function setup() {
	createCanvas(windowWidth, windowHeight);
	colorMode(HSB, 360, 100, 100);
	c = 0;
	windowResized();
}


function draw() {
	background('white');
	translate(width / 2, height / 2);
	

	stroke(255);
	// fill(c, 500, 70);
	// c += 1;
	// c = c%360;
  

	for(let y = 0; y < height; y++) {
		fill(lerpColor(noise(100), noise(400), y / height), 500, 70);
	}

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


function windowResized() {
	if(windowWidth < 550) {
		size = 10;
	} else {
		size = 100;
	}
}

	



