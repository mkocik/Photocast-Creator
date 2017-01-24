<?php

class TextImage {
	public $name;
	public $text;
	public $fontFile;
	public $fontSize;
	public $colorR;
	public $colorG;
	public $colorB;
	public $angle;
	public $textX;
	public $textY;
	
	/*  textX and textY are centered by default
		fontFile should be included to fonts/fontName.ttf
	*/
	function __construct($name, $text = "") {
		$this->name = $name;
		$this->text = $text;
		$this->fontFile = 'fonts/Verdana.ttf';
		$this->fontSize = 40;
		$this->angle = 0;
		$this->textX = null;
		$this->textY = null;
		$this->colorR = 0;
		$this->colorG = 0;
		$this->colorB = 0;
	}
	
	function setColor($r, $g, $b) {
		$this->colorR = $r;
		$this->colorG = $g;
		$this->colorB = $b;
	}
}