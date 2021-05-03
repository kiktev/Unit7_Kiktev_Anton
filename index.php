<html>
<head>
    <title>Unit 7</title>
    <meta charset="UTF-8">
</head>
<body>

	<form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
		Завантажити файл: <br><br>
		<input name="loadFile" type="file"/><br><br>
		
		Виконати задачу 1: <input name="first" type="checkbox" value="1"></input><br><br>
		Виконати задачу 2: <input name="second" type="checkbox" value="2"></input><br><br>
		Виконати задачу 3: <input name="third" type="checkbox" value="3"></input><br><br>
	  
		<input type="submit" value="Відправити форму"/><br><br>
	</form>

		<?php 
			
			include_once "Upload.php";
			
			$uploadObject = new Upload();
			$uploadObject->uploadFile(); //Завантаження файлів.
			$uploadObject->renderImage(); //Вивід зображень.
					
			if(isset($_POST['first']) == 1){
				$uploadObject->toBackup(); // Задача 1. Переміщення файлів, які створені >, ніж 3 дні тому з папки upload в backup.
			}
			
			if(isset($_POST['second']) == 2){
				$uploadObject->deleteFile(); // Задача 2. Видалення текстових файлів, які містять слово 'тест'.
			}
			
			if(isset($_POST['third']) == 3){
				$uploadObject->readAndWrite(); // Задача 3.  Зчитування текстового файлу source.txt та створення і запис файлу dest.txt. У новому файлі усі слова (розділені пробілами та переносами рядків) записані із заду на перед.
			}
						
		?>

	</body>
</html>
