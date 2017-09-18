<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Approver</title>
	<style type="text/css">
		* {
			box-sizing: border-box;
		}
		html, body {
			height: 100%;
			margin: 0;
			padding: 0;
		}
		.container {
			display: flex;
			height: 100%;
		}
		.container form {
			margin: auto;
		}
	</style>
</head>
<body>

	<div class="container">
		<form enctype="multipart/form-data" action="approver.php" method="POST">
			<input type="hidden" name="MAX_FILE_SIZE" value="30000" /><br /><br />
			Отправить FB файл: <input name="fb_data" type="file" /><br /><br />
			Отправить TL файл: <input name="tl_data" type="file" /><br /><br />
			Курс рубля к доллару <input name="rub_curr" type="text" /><br /><br />
			<input type="submit" value="Approve!" />
		</form>
	</div>

</body>
</html>