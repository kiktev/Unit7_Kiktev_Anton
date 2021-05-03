<?php

	class Upload
	{
		public $uploadDir = "upload";
		public $backupDir = "backup";
		public $dest = 'dest.txt';
		public $source = 'source.txt';
		
		public function uploadFile() {

			if (file_exists($this->uploadDir) != true) { //перевірка існування каталогу 
				mkdir($this->uploadDir);
			}
			
			if (isset($_FILES['loadFile'])) { //перевірка існування інформації про файл
				
				$fileName = $_FILES['loadFile']['name'];
				$filePath = $_FILES['loadFile']['tmp_name'];
				$uploadfile = $this->uploadDir . '/' . basename($fileName);
				
				if (move_uploaded_file($filePath , $uploadfile)) {
					//echo "Файл завантажено.\n";
				} else {
					//echo "Помилка!.\n";
				}
			}
		}

		public function renderImage() {
			
			$uploadFiles = scandir($this->uploadDir);
			
			foreach ($uploadFiles as $fileName) { 
				
				$fullName = $this->uploadDir .'/'. $fileName;
				if($fileName !== "." && $fileName !== ".." && @getimagesize($fullName) > 0){ // якщо це не директорія і якщо це зображення.
					echo '<img style="margin-left:5%;" " src="'. $fullName .'">';
				}else{
					//echo "Помилка!.\n";
				}
			}
		}
		
		public function toBackup(){ //Задача 1.
			
			$uploadFiles = scandir($this->uploadDir);
			
			if (file_exists($this->backupDir) != true) { //перевірка існування каталогу 
				mkdir($this->backupDir);
			}
			
			foreach ($uploadFiles as $fileName) {
				$fullName = $this->uploadDir .'/'. $fileName;
				if ($fileName !== ".." && $fileName != "..") {
					$createDate = filectime($fullName);
					$nowDate = time();
					$mins = ($nowDate - $createDate );	
					if ($mins > 86400*3) {
						rename($this->uploadDir . '/' . $fileName, $this->backupDir . '/' . $fileName);
						//echo "Файл переміщено.\n";
					}
				}
			}		
		}
		
		public function deleteFile() { //Задача 2. видалення текстових файлів, які містять слово 'тест'.
	
			$uploadFiles = scandir($this->uploadDir);
			
			foreach($uploadFiles as $fileName){
				 $str = pathinfo($fileName, PATHINFO_EXTENSION); // отримання розширення файлу
				 if($str == 'txt'){
					 $inFile = file_get_contents($this->uploadDir . '/' . $fileName);
					 if($inFile == 'тест'){
						 unlink($this->uploadDir . '/' . $fileName);
						 //echo "Файл видалено.\n";
					 }
				 }
			}
		}
		
		public function readAndWrite(){ // Задача 3.
				 
			if (!file_exists($this->source)) {
				$fp = fopen($this->source, "w"); 
				fwrite($fp, "Привіт світ!");
				fclose($fp);
			}
			$fileContent = file_get_contents($this->source);

			$array = explode(' ', $fileContent);	
			$array = array_reverse($array);
			
			foreach($array as $val){
				$fileOpen = fopen($this->dest, 'a+');
				fwrite($fileOpen, $val.' '."\r\n");
				fclose($fileOpen);
			}
		}
	}
	
