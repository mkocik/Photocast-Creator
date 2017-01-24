<?php

/* ATTENTION: PhotocastCreator requires ffmpeg installed. Read README first. */

require_once('../class.photocast-creator.php');
require_once('../classes/class.text-image.php');

//choose directory for images in constructor
$photocastCreator = new PhotocastCreator("images");

/*  add images to photocast with default configurations
	you can customize configuration for each TextImage object separatly 
	all images should have the same dimensions and extensions
*/
$photocastCreator->addImage(new TextImage("1.jpg", "AAAAA 1 JPG"));
$photocastCreator->addImage(new TextImage("2.jpg", "AAAAA 2 JPG"));
$photocastCreator->addImage(new TextImage("3.jpg", "AAAAA 3 JPG"));

$textImage = new TextImage("4.jpg", "AAAAA 4 JPG");
$textImage->fontSize = 80;
$textImage->angle = 45;
$textImage->textX = 200;
$textImage->textY = 200;
$textImage->setColor(255,255,0);

$photocastCreator->addImage($textImage);

/*
	you can customize extension by $photocastCreator->setExtension
	you can also customize photocast framerate by $photocastCreator->setFramerate
*/

/* not required */
$photocastCreator->setAudio("audio/First_Touch.mp3");
$photocastCreator->setCutAudio(true);
$photocastCreator->setUseLogging(true);
/* end not required */

//carefull - only 1 photocast with given path + name can exists. Otherwise PhotocastCreator does nothing.
$photocastCreator->generatePhotocast("out.mp4");
