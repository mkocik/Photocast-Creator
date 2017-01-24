<?php

class ImageExtender {
	private $image;
	private $fileCounter;
	private $outputDirectory;
	private $namePattern;
	private $color;
	
	function __construct() {
		$this->namePattern = "%03d";
		$this->outputDirectory = uniqid('tmp');
		
		mkdir($this->outputDirectory);
	}
	
	function setImage($image){
		$this->image = $image;
	}
	
	function setColor($r, $g, $b) {
		$this->color = ImageColorAllocate($this->image, $r, $g, $b);
	}
	
	function setOutputDirectory($outputDirectory){
		$this->outputDirectory = $outputDirectory;
	}
	
	function getOutputDirectory() {
		return $this->outputDirectory;
	}
	
	function setNamePattern($namePattern){
		$this->namePattern = $namePattern;
	}
	
	function getNamePattern() {
		return $this->namePattern;
	}
	
	function addTextToImage($text, $fontSize, $angle, $fontFile, $x = null, $y = null) {
		if($x === null){
			$x = $this->centerX($text, $fontSize, $angle, $fontFile);
		}
		
		if($y === null){
			$y = $this->centerY($text, $fontSize, $angle, $fontFile);
		}
		
		Imagettftext($this->image, $fontSize, $angle, $x, $y, $this->color, $fontFile, $text);
	}
	
	function saveImage(){
		imagejpeg($this->image, $this->outputDirectory . "/" . sprintf($this->namePattern, $this->fileCounter) . ".jpg");
		$this->fileCounter++;
	}
	
	function clearTmpData() {
		$this->removeDirectoryWithContent($this->outputDirectory);
	}
	
	private function centerX($text, $fontSize, $angle, $fontFile) {
		$text_box = imagettfbbox($fontSize, $angle, $fontFile, $text);
		$text_width = $text_box[2]-$text_box[0];
		
		return (imagesx($this->image)/2) - ($text_width/2);
	}
	
	private function centerY($text, $fontSize, $angle, $fontFile) {
		$text_box = imagettfbbox($fontSize, $angle, $fontFile, $text);
		$text_height = $text_box[7]-$text_box[1];
		
		return (imagesy($this->image)/2) - ($text_height/2);
	}
	
	private function removeDirectoryWithContent($path) {
		if (is_dir($path) === true) {
			
			$files = array_diff(scandir($path), array('.', '..'));
			foreach ($files as $file) {
				$this->removeDirectoryWithContent(realpath($path) . '/' . $file);
			}
			
			return rmdir($path);
		}

		else if (is_file($path) === true) {
			return unlink($path);
		}

		return false;
	}
}