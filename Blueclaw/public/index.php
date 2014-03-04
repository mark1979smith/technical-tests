<?php 
ini_set ( 'include_path', get_include_path () . PATH_SEPARATOR . dirname ( __FILE__ ) . '/../lib/' );
require_once 'People.php';
$people = new People();
$data = $people->load();
?>
<html>
<head>
<title>Blueclaw technical test</title>
<link rel="stylesheet" href="/css/style.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
</head>
<body>
	<?php if (is_array($_GET)) :
		if (array_key_exists('updated', $_GET)) :?>
		<div id="flashMessenger" class="confirm">
			<p><strong>The form has been updated.</strong></p>
		</div>
		<?php elseif (array_key_exists('status', $_GET) && $_GET['status'] == 'false') :?>
		<div id="flashMessenger" class="error">
			<p><strong><?= (array_key_exists('message', $_GET) ? base64_decode($_GET['message']) : 'Form submission has failed.') ?></strong></p>
		</div>
		<?php endif ?>
	<?php endif;?>
	<form id="people" action="save.php" method="post">
		<table>
			<tr>
				<th>First name</th>
				<th>Last name</th>
				<th>Job title</th>
			</tr>
			<?php foreach(range(0,4) as $key) :?>
			<tr>
				<td><input type="text" name="firstname[<?= $key ?>]" id="firstname[<?= $key ?>]" value="<?= (isset($data->firstname) ? htmlspecialchars($data->firstname[$key]) : '') ?>" /></td>
				<td><input type="text" name="lastname[<?= $key ?>]" id="lastname[<?= $key ?>]"	value="<?= (isset($data->lastname) ? htmlspecialchars($data->lastname[$key]) : '') ?>" /></td>
				<td><input type="text" name="jobtitle[<?= $key ?>]" id="jobtitle[<?= $key ?>]"	value="<?= (isset($data->jobtitle) ? htmlspecialchars($data->jobtitle[$key]) : '') ?>" /></td>
			</tr>
			<?php endforeach;?>
			</table>
		<input type="submit" value="  OK  " />
	</form>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#people').bind('submit', function(e) {
				var f = $(this);
				var message = 'The form has been updated.';
				$.post($(f).prop('action'), $(f).serialize(), function(data) {
					$('#flashMessenger').remove();
					if (data.status == true)
					{
						$(f).before('<div id="flashMessenger" class="confirm"><p><strong>' + message + '</strong></p></div>');
					}
					else
					{
						if(!data.hasOwnProperty('message'))
						{
							message = 'Form submission has failed.';
						}
						else
						{
							message = data.message;
						}
						$(f).before('<div id="flashMessenger" class="error"><p><strong>' + message + '</strong></p></div>');
					}
				}, 'json');
				e.preventDefault();
			});
		});
	</script>
</body>
</html>
