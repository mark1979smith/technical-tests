<?php
	ini_set('include_path', get_include_path().PATH_SEPARATOR.dirname(__FILE__).'/../lib/');
?>
<html>
	<head>
		<title>Blueclaw technical test</title>
	</head>
	<body>
		<form id="people">
			<table>
				<tr>
					<th>First name</th>
					<th>Last name</th>
				</tr>
				<tr>
					<td><input type="text" name="firstname[0]" id="firstname[0]" value="Leonard" /></td>
					<td><input type="text" name="lastname[0]" id="lastname[0]" value="Hofstader" /></td>
				</tr>
				<tr>
					<td><input type="text" name="firstname[1]" id="firstname[1]" value="Sheldon" /></td>
					<td><input type="text" name="lastname[1]" id="lastname[1]" value="Cooper" /></td>
				</tr>
				<tr>
					<td><input type="text" name="firstname[2]" id="firstname[2]" value="Raj" /></td>
					<td><input type="text" name="lastname[2]" id="lastname[2]" value="Koothrapali" /></td>
				</tr>
				<tr>
					<td><input type="text" name="firstname[3]" id="firstname[3]" value="Howard" /></td>
					<td><input type="text" name="lastname[3]" id="lastname[3]" value="Wolowitz" /></td>
				</tr>
				<tr>
					<td><input type="text" name="firstname[4]" id="firstname[4]" value="Penny" /></td>
					<td><input type="text" name="lastname[4]" id="lastname[4]" value="" /></td>
				</tr>
			</table>
			<input type="submit" value="  OK  " />
		</form>
	</body>
</html>
