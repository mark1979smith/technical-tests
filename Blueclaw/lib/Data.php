<?php
require_once 'Generic.php';
/**
 * Data
 * Included in this class are the core methods to load and save contents.
 * 
 * @author Mark Smith
 */
abstract class Data extends Generic
{
	/**
	 * Data File
	 * This is used to define the location of the file storing the data
	 * @var string
	 */
	protected $_dataFile = NULL;
	
	/**
	 * Load file contents of a given data file
	 * @throws Exception
	 * @return multitype:|mixed
	 */
	public function load() 
	{
		if (is_null ( $this->getDataFile () )) 
		{
			throw new Exception ( 'Data File is not set' );
		}
		
		if (!file_exists($this->getDataFile()))
		{
			return array();
		}
		else
		{
			return json_decode(file_get_contents($this->getDataFile()));
		}
	}
	
	/**
	 * Save contents to a given data file
	 * @throws Exception
	 * @return boolean
	 */
	public function save() 
	{
		if (is_null ( $this->getDataFile () )) 
		{
			throw new Exception ( 'Data File is not set' );
		}
		
		if (!is_dir(dirname($this->getDataFile())))
		{
			throw new Exception('Directory holding data file does not exist');
		}
		
		if (!$handle = fopen($this->getDataFile(), 'w')) 
		{
			throw new Exception('Cannot open file');
		}
		
		// Write $somecontent to our opened file.
		if (fwrite($handle, $this) === FALSE) 
		{
			throw new Exception('Cannot write to file');
		}
		
		fclose($handle);
		
		return true;
	}
	
	/**
	 * Setter for the data file
	 * @param string $dataFile
	 * @return Data
	 */
	public function setDataFile($dataFile) 
	{
		$this->_dataFile = $dataFile;
		
		return $this;
	}
	
	/**
	 * Getter for the data file
	 * @return string
	 */
	public function getDataFile() 
	{
		return $this->_dataFile;
	}
}