<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Approver</title>
</head>
<body>

<!-- Тип кодирования данных, enctype, ДОЛЖЕН БЫТЬ указан ИМЕННО так -->
<form enctype="multipart/form-data" action="approver.php" method="POST">
	<!-- Поле MAX_FILE_SIZE должно быть указано до поля загрузки файла -->
	<input type="hidden" name="MAX_FILE_SIZE" value="30000" />
	<!-- Название элемента input определяет имя в массиве $_FILES -->
	Отправить FB файл: <input name="fb_data" type="file" />
	<!-- Название элемента input определяет имя в массиве $_FILES -->
	Отправить TL файл: <input name="tl_data" type="file" />
	<input type="submit" value="Send File" />
</form>

</body>
</html>