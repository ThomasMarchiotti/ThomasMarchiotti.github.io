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

	const m = 100;
  
	const topR = 255 * noise(frameCount / m);
	const topG = 255 * noise(1000 + frameCount / m);
	const topB = 255 * noise(2000 + frameCount / m);
	const bottomR = 255 * noise(3000 + frameCount / m);
	const bottomG = 255 * noise(4000  + frameCount / m);
	const bottomB = 255 * noise(5000 + frameCount / m);
  
	const topColor = color(topR, topG, topB);
	const bottomColor = color(bottomR, bottomG, bottomB);

	for(let y = 0; y < height; y++) {
		fill(lerpColor(topColor, bottomColor, y / height), 500, 70);
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

	



