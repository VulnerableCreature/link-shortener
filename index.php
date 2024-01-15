<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Link Shortener | IQ Media</title>
	<style>
		.form-request {
			height: 100vh;
			display: flex;
			flex-direction: column;
			justify-content: center;
			align-items: center;
		}

		.form-request form {
			margin: 0 auto;
		}

		.form-request form>input[type="text"] {
			padding: 6px 8px 6px 8px;
			width: 500px;
			border: 1px solid #c8c8c8;
			border-radius: 4px;
		}

		.form-request form>input[type="text"]:focus {
			outline-color: #217aff;
		}

		.form-request form>button {
			padding: 6px 8px 6px 8px;
			width: 200px;
			border: 1px solid #c8c8c8;
			border-radius: 4px;
			cursor: pointer;
			font-size: 14px;
			font-style: italic;
		}

		.form-request form>button:hover {
			background-color: black;
			color: white;
			transition: all 0.1s ease-out;
			transition-duration: 0.5s;
		}

		.result {
			margin-top: 10px;
			font-size: 16px;
			font-style: normal;
			font-weight: 700;
			letter-spacing: 1.4px;
			text-decoration: underline;
			color: red;
		}
	</style>
</head>

<body>
	<div class="form-request">
		<form id="UrlForm">
			<input type="text" name="original_url" id="originalUrl">
			<button type="button">Сократить ссылку</button>
		</form>
		<div class="result" id="shortUrlResult">123</div>
	</div>
</body>

</html>