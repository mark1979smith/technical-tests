<?php
class Payday
{
	/**
	 * Define the Payday Offset
	 * A negative figure will define X days from the end of the month 
	 * and a positive figure will define X days from the beginning of the month
	 * @var unknown
	 */
	const PAYDAY_OFFSET = -1;
	/**
	 * Year in 4-digit format
	 * @var integer
	 */
	protected $_year = NULL;
	
	/**
	 * Month in 1 or 2-digit format
	 * @var integer
	 */
	protected $_month = NULL;
	
	/**
	 * get the date pay day falls on
	 * 
	 * @return DateTime
	 * @throws Exception
	 */
	public function getDate()
	{
		// Ensure month is provided
		if (!$this->getMonth())
		{
			throw new Exception('Month must be provided', 101);
		}
		
		// Ensure year is provided
		if (!$this->getYear())
		{
			throw new Exception('Year must be provided', 102);
		}
		
		if (self::PAYDAY_OFFSET <= 0)
		{
			// With payday offset being negative it is X days before the end of the month
			$daysInMonth = date('t', mktime(0,0,0,$this->getMonth(),1,$this->getYear()));
			$payDay = $daysInMonth += self::PAYDAY_OFFSET;
		}
		else 
		{
			$payDay = self::PAYDAY_OFFSET;
		}
		
		$dateTime = new DateTime();
		$dateTime->setDate($this->getYear(), $this->getMonth(), $payDay);
		
		// Ensure day is not on weekend
		$payDayNumber = $dateTime->format('N');
		if (in_array($payDayNumber, array(6, 7)))
		{
			// If on a weekend, we need to subtract 1 or 2 days to get into a week day.
			$dateTime->sub(new DateInterval('P' . ($payDayNumber-5) .'D'));
		}
		
		// Ensure day is not a bank holiday
		if (in_array($dateTime->format('Y-m-d'), $this->_calculateBankHolidays($dateTime->format('Y'))))
		{
			do {
				// Substract the date when the date is a bank holiday OR is a weekend
				$dateTime->sub(new DateInterval('P1D'));
			} while (in_array($dateTime->format('Y-m-d'), $this->_calculateBankHolidays($dateTime->format('Y'))) || in_array($dateTime->format('N'), array(6, 7)));
		}
		
		return $dateTime;
	}
	
	/**
	 * Get the Funds Send Date
	 * Returns a DateTime object of when to process the payroll
	 * 
	 * @param DateTime $date
	 * @return DateTime
	 */
	public function getFundsSendDate(DateTime $date)
	{
		// We clone $date so we done inadvertently modify the same object
		$date = clone $date;
		// Start the $index at 1 as the day wages are received is classed as one working day
		$index = 1;
		do {
			// deduct one day from the given pay day $date
			$date->sub(new DateInterval('P1D'));
			if (
				// if the subtracted date is not a weekend - increment the $index
				!in_array($date->format('N'), array(6,7)) &&
				// AND if the subtracted date is not a bank holiday 
				!in_array($date->format('Y-m-d'), $this->_calculateBankHolidays($date->format('Y'))))
			{
				$index++;
			}
			// As $index is incremented - it will stop when it reaches 4.
		} while ($index < 4);
		
		return $date;
	}
	
	/**
	 * Setter to set the Month number
	 * @param integr $month
	 * @return PayDay
	 */
	public function setMonth($month)
	{
		$this->_month = $month;
		
		return $this;
	}
	
	/**
	 * Getter to get the month number
	 * @return number
	 */
	public function getMonth()
	{
		return $this->_month;
	}
	
	/**
	 * Setter to set the Year
	 * @param integer $year
	 * @return PayDay
	 */
	public function setYear($year)
	{
		$this->_year = $year;
		
		return $this;
	}
	
	/**
	 * Getter to get the year
	 * @return number
	 */
	public function getYear()
	{
		return $this->_year;
	}
	
	/**
	 * Calculate UK Bank Holidays
	 * @link http://www.php.net/manual/en/ref.calendar.php#77159
	 * @param intger $yr
	 * @return array
	 */
	protected function _calculateBankHolidays($yr) 
	{

	    $bankHols = array();
	
	    // New year's:
	    switch ( date("w", strtotime("$yr-01-01 12:00:00")) ) {
	        case 6:
	            $bankHols[] = "$yr-01-03";
	            break;
	        case 0:
	            $bankHols[] = "$yr-01-02";
	            break;
	        default:
	            $bankHols[] = "$yr-01-01";
	    }

	    // Good friday:
	    $bankHols[] = date("Y-m-d", strtotime( "+".(easter_days($yr) - 2)." days", strtotime("$yr-03-21 12:00:00") ));
	
	    // Easter Monday:
	    $bankHols[] = date("Y-m-d", strtotime( "+".(easter_days($yr) + 1)." days", strtotime("$yr-03-21 12:00:00") ));
	
	    // May Day:
	    if ($yr == 1995) {
	        $bankHols[] = "1995-05-08"; // VE day 50th anniversary year exception
	    } else {
	        switch (date("w", strtotime("$yr-05-01 12:00:00"))) {
	            case 0:
	                $bankHols[] = "$yr-05-02";
	                break;
	            case 1:
	                $bankHols[] = "$yr-05-01";
	                break;
	            case 2:
	                $bankHols[] = "$yr-05-07";
	                break;
	            case 3:
	                $bankHols[] = "$yr-05-06";
	                break;
	            case 4:
	                $bankHols[] = "$yr-05-05";
	                break;
	            case 5:
	                $bankHols[] = "$yr-05-04";
	                break;
	            case 6:
	                $bankHols[] = "$yr-05-03";
	                break;
	        }
	    }
	
	    // Whitsun:
	    if ($yr == 2002) { // exception year
	        $bankHols[] = "2002-06-03";
	        $bankHols[] = "2002-06-04";
	    } else {
	        switch (date("w", strtotime("$yr-05-31 12:00:00"))) {
	            case 0:
	                $bankHols[] = "$yr-05-25";
	                break;
	            case 1:
	                $bankHols[] = "$yr-05-31";
	                break;
	            case 2:
	                $bankHols[] = "$yr-05-30";
	                break;
	            case 3:
	                $bankHols[] = "$yr-05-29";
	                break;
	            case 4:
	                $bankHols[] = "$yr-05-28";
	                break;
	            case 5:
	                $bankHols[] = "$yr-05-27";
	                break;
	            case 6:
	                $bankHols[] = "$yr-05-26";
	                break;
	        }
	    }
	
	    // Summer Bank Holiday:
	    switch (date("w", strtotime("$yr-08-31 12:00:00"))) {
	        case 0:
	            $bankHols[] = "$yr-08-25";
	            break;
	        case 1:
	            $bankHols[] = "$yr-08-31";
	            break;
	        case 2:
	            $bankHols[] = "$yr-08-30";
	            break;
	        case 3:
	            $bankHols[] = "$yr-08-29";
	            break;
	        case 4:
	            $bankHols[] = "$yr-08-28";
	            break;
	        case 5:
	            $bankHols[] = "$yr-08-27";
	            break;
	        case 6:
	            $bankHols[] = "$yr-08-26";
	            break;
	    }
	
	    // Christmas:
	    switch ( date("w", strtotime("$yr-12-25 12:00:00")) ) {
	        case 5:
	            $bankHols[] = "$yr-12-25";
	            $bankHols[] = "$yr-12-28";
	            break;
	        case 6:
	            $bankHols[] = "$yr-12-27";
	            $bankHols[] = "$yr-12-28";
	            break;
	        case 0:
	            $bankHols[] = "$yr-12-26";
	            $bankHols[] = "$yr-12-27";
	            break;
	        default:
	            $bankHols[] = "$yr-12-25";
	            $bankHols[] = "$yr-12-26";
	    }
	
	    // Millenium eve
	    if ($yr == 1999) {
	        $bankHols[] = "1999-12-31";
	    }
	
	    return $bankHols;
	
	}
}

