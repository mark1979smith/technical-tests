<?php
ini_set ( 'include_path', get_include_path () . PATH_SEPARATOR . dirname ( __FILE__ ) . '/../lib/' );
if (is_array ( $_POST ) && ! empty ( $_POST )) 
{
	require_once 'People.php';
	
	try {
		$people = new People();
		$status = $people
			->setFirstName($_POST['firstname'])
			->setLastName($_POST['lastname'])
			->setJobTitle($_POST['jobtitle'])
			->save();
	}
	catch (Exception $e)
	{
		$status = false;
		$message = $e->getMessage();
		
		if (file_exists($people->getDataFile()))
		{
			unlink($people->getDataFile());
		}
	}
	if ($people->isAjax())
	{
		if (!isset($message))
			$message = NULL;
		
		echo json_encode(array('status' => $status, 'message' => $message));
	}
	else 
	{
		if ($status === true)
		{
			header('Location: /index.php?updated');
			exit;
		}
		else 
		{
			header('Location: /index.php?status=false&message='. base64_encode($message));
		}
	}
}

