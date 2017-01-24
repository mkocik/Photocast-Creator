<?php

class ImageHandler {
	private $directoryPath;
	
	function __construct($directoryPath) {
		$this->directoryPath = $directoryPath;
	}
	
	function createImage($fileName) {
		$filePath = $this->directoryPath . "/" . $fileName;
		
		$this->checkIfFileExists($filePath);
		
		switch (strtolower(pathinfo($filePath, PATHINFO_EXTENSION))) {
			case 'jpeg':
			case 'jpg':
				return imagecreatefromjpeg($filePath);
			break;

			case 'png':
				return imagecreatefrompng($filePath);
			break;

			case 'gif':
				return imagecreatefromgif($filePath);
			break;

			default:
				throw new InvalidArgumentException('File "'.$filePath.'" is not valid jpg, png or gif image.');
			break;
		}
	}
	
	private function checkIfFileExists($path) {
		if (!file_exists($path)) {
			throw new InvalidArgumentException('File "'.$path.'" not found.');
		}
	}
}