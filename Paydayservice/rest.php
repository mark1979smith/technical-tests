<?php

// set the lib/ folder in the include path
set_include_path($_SERVER['DOCUMENT_ROOT'] . '/lib' . PATH_SEPARATOR . get_include_path());

// enables us to auto load library files
function __autoload($class_name) {
   	include str_replace('_', '/', $class_name) . '.php';
}

// Start the rest server
$server = new Zend_Rest_Server();
$server->addFunction('getdates');
$server->handle();

/**
 * getdates()
 * This function will return a DomDocument which Zend Rest Server will output as XML
 * @param number $year
 * @param number $month
 * @param string $dateFormat
 * @return DOMDocument
 */
function getdates($year = 0, $month = 0, $dateFormat = 'Y-m-d')
{
   	// Define default values
    $status = 200;
    $message = 'SUCCESS';
    
    // Create the XML document
    $dom = new DOMDocument('1.0', 'iso-8859-1');
    // Add root element
    $root = $dom->createElement('paydayservice');
    $dom->appendChild($root);
    // Add query element
    $query = $dom->createElement('query');
    $root->appendChild($query);
    // Add month and year value
    $m = $dom->createElement('month', $month);
    $query->appendChild($m);
    $y = $dom->createElement('year', $year);
    $query->appendChild($y);
    
    try {
    	$payday = new Payday();
	    /*
	     * $payDate
	     * @var DateTime
	     */
	    $payDate = $payday
	    	->setMonth($month)
	    	->setYear($year)
	    	->getDate();
	    	
	    /*
	     * $processDate
	     * @var DateTime
	     */
	    $processDate = $payday
	    	->getFundsSendDate($payDate);
	    	
	    // Add result element
	    $result = $dom->createElement('result');
	    $root->appendChild($result);
	    // Add process date
	    $element = $dom->createElement('process_date', $processDate->format($dateFormat));
	    $result->appendChild($element);
	    // Add pay date
	    $element = $dom->createElement('pay_date', $payDate->format($dateFormat));
	    $result->appendChild($element);
    } catch(Exception $e)
    {
    	// Overwrite default values
    	$status = $e->getCode();
    	$message = $e->getMessage();
    }
    	
    // Add status
    $stat = $dom->createElement('status', $status);
    $root->appendChild($stat);
    $mess = $dom->createElement('message', $message);
    $root->appendChild($mess);
    

	return $dom;
}