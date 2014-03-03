<?php
require_once 'Payday.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * Payday test case.
 */
class PaydayTest extends PHPUnit_Framework_TestCase {
	
	/**
	 *
	 * @var Payday
	 */
	private $Payday;
	
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		
		$this->Payday = new Payday();
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		$this->Payday = null;
		
		parent::tearDown ();
	}
	
	/**
	 * Constructs the test case.
	 */
	public function __construct() {

	}
	
	/**
	 * Tests Payday->getDate()
	 */
	public function testGetDate() {
		$this->assertInstanceOf('DateTime', $this->Payday->setMonth(1)->setYear(2014)->getDate());
		$this->assertEquals('2014-01-30', $this->Payday->setMonth(1)->setYear(2014)->getDate()->format('Y-m-d'));
		$this->assertEquals('2014-02-27', $this->Payday->setMonth(2)->setYear(2014)->getDate()->format('Y-m-d'));
		$this->assertEquals('2014-03-28', $this->Payday->setMonth(3)->setYear(2014)->getDate()->format('Y-m-d'));
		$this->assertEquals('2014-04-29', $this->Payday->setMonth(4)->setYear(2014)->getDate()->format('Y-m-d'));
		$this->assertEquals('2014-05-30', $this->Payday->setMonth(5)->setYear(2014)->getDate()->format('Y-m-d'));
		$this->assertEquals('2014-06-27', $this->Payday->setMonth(6)->setYear(2014)->getDate()->format('Y-m-d'));
		$this->assertEquals('2014-07-30', $this->Payday->setMonth(7)->setYear(2014)->getDate()->format('Y-m-d'));
		$this->assertEquals('2014-08-29', $this->Payday->setMonth(8)->setYear(2014)->getDate()->format('Y-m-d'));
		$this->assertEquals('2014-09-29', $this->Payday->setMonth(9)->setYear(2014)->getDate()->format('Y-m-d'));
		$this->assertEquals('2014-10-30', $this->Payday->setMonth(10)->setYear(2014)->getDate()->format('Y-m-d'));
		$this->assertEquals('2014-11-28', $this->Payday->setMonth(11)->setYear(2014)->getDate()->format('Y-m-d'));
		$this->assertEquals('2014-12-30', $this->Payday->setMonth(12)->setYear(2014)->getDate()->format('Y-m-d'));
	}
	
	/**
	 * Tests Payday->getFundsSendDate()
	 */
	public function testGetFundsSendDate() 
	{
		$this->assertInstanceOf('DateTime', $this->Payday->getFundsSendDate(new DateTime('2014-01-30')));
		$this->assertEquals('2014-01-27', $this->Payday->getFundsSendDate($this->Payday->setMonth(1)->setYear(2014)->getDate())->format('Y-m-d'));
		$this->assertEquals('2014-02-24', $this->Payday->getFundsSendDate($this->Payday->setMonth(2)->setYear(2014)->getDate())->format('Y-m-d'));
		$this->assertEquals('2014-03-25', $this->Payday->getFundsSendDate($this->Payday->setMonth(3)->setYear(2014)->getDate())->format('Y-m-d'));
		$this->assertEquals('2014-04-24', $this->Payday->getFundsSendDate($this->Payday->setMonth(4)->setYear(2014)->getDate())->format('Y-m-d'));
		$this->assertEquals('2014-05-27', $this->Payday->getFundsSendDate($this->Payday->setMonth(5)->setYear(2014)->getDate())->format('Y-m-d'));
		$this->assertEquals('2014-06-24', $this->Payday->getFundsSendDate($this->Payday->setMonth(6)->setYear(2014)->getDate())->format('Y-m-d'));
		$this->assertEquals('2014-07-25', $this->Payday->getFundsSendDate($this->Payday->setMonth(7)->setYear(2014)->getDate())->format('Y-m-d'));
		$this->assertEquals('2014-08-26', $this->Payday->getFundsSendDate($this->Payday->setMonth(8)->setYear(2014)->getDate())->format('Y-m-d'));
		$this->assertEquals('2014-09-24', $this->Payday->getFundsSendDate($this->Payday->setMonth(9)->setYear(2014)->getDate())->format('Y-m-d'));
		$this->assertEquals('2014-10-27', $this->Payday->getFundsSendDate($this->Payday->setMonth(10)->setYear(2014)->getDate())->format('Y-m-d'));
		$this->assertEquals('2014-11-25', $this->Payday->getFundsSendDate($this->Payday->setMonth(11)->setYear(2014)->getDate())->format('Y-m-d'));
		$this->assertEquals('2014-12-23', $this->Payday->getFundsSendDate($this->Payday->setMonth(12)->setYear(2014)->getDate())->format('Y-m-d'));
	}
	
	/**
	 * Tests Payday->setMonth()
	 */
	public function testSetMonth() {
		
		$this->assertInstanceOf('Payday', $this->Payday->setMonth(10));
	}
	
	/**
	 * Tests Payday->getMonth()
	 */
	public function testGetMonth() {
		
		$this->assertEquals('3', $this->Payday->setMonth(3)->getMonth());
	}
	
	/**
	 * Tests Payday->setYear()
	 */
	public function testSetYear() {
		
		$this->assertInstanceOf('Payday', $this->Payday->setYear(2014));
	}
	
	/**
	 * Tests Payday->getYear()
	 */
	public function testGetYear() {
		
		$this->assertEquals('2004', $this->Payday->setYear('2004')->getYear());
	}
}

