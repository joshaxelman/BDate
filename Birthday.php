<?php
/**
 * A simple, abstracted class for working with a user's birthday. 
 * Pass the users birthday as a string and turn it into a birthday
 * object that contains all of the pertinent bday info. 
 *
 * PHP version 5.3+
 *
 * The MIT License (MIT)
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @category   DateTime Utility
 * @package    BDate
 * @author    	  Josh Axelman joshaxelman@gmail.com 
 * @version     1
 * @link          http://pear.php.net/package/PackageName
 */

namespace BDate;

class Birthday
{
	private $timezone;
	private $bdate;
	private $today;
	
	public function __construct($date)
	{
		$this->timezone = new \DateTimeZone('America/Los_Angeles');
		$this->bdate = new \DateTime($date, $this->timezone);
		$this->today = new \DateTime('now', $this->timezone);
		$this->getPieces();
		$this->getAge();
		// $this->getHolidays();
	}
	
	/**
	 * Method to break apart today's year
	 * and bday pieces.
	 */
	private function getPieces()
	{
		$this->currentYear = $this->today->format('Y');
		$this->bdayYear = $this->bdate->format('Y');
		$this->bdayMonth = $this->bdate->format('m');
		$this->bdayDay = $this->bdate->format('d');
	}

	/**
	 * Method to get the age of the user. 
	 * This uses actual internal date functions
	 * instead of a year subtraction. Month and day
	 * are taken into account. 
	 * This is called in the contructor but doesn't need 
	 * to be. 
	 */
	public function getAge()
	{
		$interval = $this->bdate->diff($this->today);
		$this->age = $interval->y;
	}
	
	/**
	 * Method to figure out the days 
	 * until the users birthday. This only 
	 * returns positive numbers. If the bday has 
	 * past, it looks to the next year. 
	 */
	public function daysTillBday()
	{
		$bdayCurrent = new DateTime($this->currentYear .'/' .$this->bdayMonth . '/' . $this->bdayDay, $this->timezone);
		if ($bdayCurrent > $this->today) {
			$interval = $bdayCurrent->diff($this->today);
			$this->daysTill = $interval->days;
		} else {
			$add = new DateInterval('P1Y');
			$nextBday = $bdayCurrent->add($add);
			$interval = $nextBday->diff($this->today);
			$this->daysTillNextBday = $interval->days;
		}
	}
	
}