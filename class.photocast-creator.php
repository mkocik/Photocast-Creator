<?php

require_once('classes/class.image-extender.php');
require_once('classes/class.image-handler.php');

class PhotocastCreator {
	private $images;
	private $extension;
	private $framerate;
	private $useLogging;
	private $audio;
	private $cutAudio;
	
	function __construct($directoryPath) {
		$this->directoryPath = $directoryPath;
		$this->images = array();
		$this->extension = "jpg";
		$this->framerate = 1/5;
		$this->useLogging =  false;
		$this->audio = null;
		$this->cutAudio = false;
	}
	
	function addImage($img){
		$this->images[] = $img;
	}
	
	function setAudio($audio) {
		$this->audio = $audio;
	}
	
	/* $cutAudio = true shortens audio to the duration of videoclip  */
	function setCutAudio($cutAudio) {
		$this->cutAudio = $cutAudio;
	}
	
	function setExtension($extension) {
		$this->extension = $extension;
	}
	
	function setUseLogging($useLogging) {
		$this->useLogging = $useLogging;
	}
	
	/* $rate = 1/X means that each image is displayed X seconds*/
	function setFramerate($rate) {
		$this->framerate = $rate;
	}
	
	function generatePhotocast($output) {
		$imageHandler = new ImageHandler($this->directoryPath);
		$imageExtender = new ImageExtender();
		$additionalParams = "";
		
		foreach($this->images as $textImage) {
			$tmpImg = $imageHandler->createImage($textImage->name);
			$imageExtender->setImage($tmpImg);
			$imageExtender->setColor($textImage->colorR, $textImage->colorG, $textImage->colorB);
			$imageExtender->addTextToImage($textImage->text, $textImage->fontSize, $textImage->angle, $textImage->fontFile, $textImage->textX, $textImage->textY);
			$imageExtender->saveImage();
		}

		if($this->audio != null) {
			$additionalParams .= " -i $this->audio ";
		}	

		if($this->cutAudio){
			$output = " -shortest " . $output;
		}
		
		if($this->useLogging){
			$additionalParams .= " 2>&1 ";
		}
		
		echo shell_exec("ffmpeg -f image2 -framerate " . $this->framerate ." -i " . $imageExtender->getOutputDirectory() . "/" . $imageExtender->getNamePattern() . "." . $this->extension . " -r 25 -vcodec libx264 " . $output . $additionalParams);
	
		$imageExtender->clearTmpData();
	}
}