<?php
require_once 'Data.php';
class People extends Data {
	
	/**
	 * First Name
	 * @var string
	 */
	protected $_firstName = NULL;
	
	/**
	 * Last Name
	 * @var string
	 */
	protected $_lastName = NULL;
	
	/**
	 * Job Title
	 * @var string
	 */
	protected $_jobTitle = NULL;
	
	/**
	 * Constructor
	 * This is where we set the data file. We set it here because other data may require a seperate file.
	 */
	public function __construct()
	{
		// We store the file out of the public directory to stop it being downloaded through the browser
		$this->setDataFile('../data/data.ser');
	}
	
	/**
	 * Magic method to catch anything not here already
	 * Defining one method makes it unnecessary to create an increasing amount of setters and getters.
	 * 
	 * @param string $name
	 * @param array $arguments
	 * @return People
	 */
	public function __call($name, $arguments) 
	{
		// Used as setter
		if (preg_match ( '/^set/', $name )) 
		{
			$this->_setDataField ( preg_replace ( '/^set/', '', $name ), reset($arguments) );
			
			return $this;
		}
		// Used as getter
		else if (preg_match('/^get/', $name))
		{
			$name = preg_replace('/^get/', '', $name);
			
			return $this->{'_'. strtolower($name[0]) . substr($name, 1)};
		}
	}
	
	/**
	 * Magic toString method is used when writing text to file
	 * @return string
	 */
	public function __toString()
	{
		return json_encode($this->toArray());
	}
	
	/**
	 * toArray
	 * Turns the People object into a readable array
	 * @return array
	 */
	public function toArray()
	{
		return array(
			'firstname' => $this->getFirstName(),
			'lastname'	=> $this->getLastName(),
			'jobtitle'  => $this->getJobTitle()
		);
	}
	
	/**
	 * setDataField
	 * This is used with any setter
	 * e.g. setJobTitle will assign the value to $this->_jobTitle
	 * @param string $name
	 * @param mixed $value
	 */
	protected function _setDataField($name, $value)
	{
		$this->{'_'. strtolower($name[0]) . substr($name, 1)} = $value;
	}
	
}