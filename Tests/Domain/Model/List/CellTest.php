<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2010-2011 punkt.de GmbH - Karlsruhe, Germany - http://www.punkt.de
 *  Authors: Daniel Lienert, Michael Knoll, Christoph Ehscheidt
 *  All rights reserved
 *
 *  For further information: http://extlist.punkt.de <extlist@punkt.de>
 *
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Testcase for row object. 
 * 
 * @author Michael Knoll 
 * @package Typo3
 * @subpackage pt_extlist
 */
class Tx_PtExtlist_Tests_Domain_Model_List_Cell_testcase extends Tx_Extbase_Tests_Unit_BaseTestCase {


	/**
	 * @test
	 */
	public function classExists() {
		$this->assertTrue(class_exists('Tx_PtExtlist_Domain_Model_List_Cell'));
	}


	public function cellValueDataProvider() {

		$testObject = new Tx_PtExtlist_Tests_Domain_Model_List_Cell_testcase_testClass();

		return array(
			'object' => array('value' => $testObject, 'expected' => 'OBJECT::' . get_class($testObject)),

			'string' => array('value' => 'test', 'expected' => 'test'),
			'emptyString' => array('value' => '', 'expected' => ''),

			'integerPositive' => array('value' => 1, 'expected' => '1'),
			'integerZero' => array('value' => 0, 'expected' => '0'),
			'integerNegative' => array('value' => -100, 'expected' => '-100'),

			'array' => array('value' => array(1,2), 'expected' => implode(', ', array(1,2))),

			'null' => array('value' => NULL, 'expected' => ''),
		);
	}


	/**
	 * @test
	 * @dataProvider cellValueDataProvider
	 *
	 * @param $value
	 * @param $expected
	 */
	public function toStringTest($value, $expected) {

		$cell = new Tx_PtExtlist_Domain_Model_List_Cell($value);
		$this->assertEquals($expected, $cell->__toString());
	}

}

class Tx_PtExtlist_Tests_Domain_Model_List_Cell_testcase_testClass {}
?>