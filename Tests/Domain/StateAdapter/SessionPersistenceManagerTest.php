<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Daniel Lienert <lienert@punkt.de>, Michael Knoll <knoll@punkt.de>
*  All rights reserved
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
 * 
 *
 * @package TYPO3
 * @subpackage pt_extlist
 */
class Tx_PtExtlist_Tests_Domain_StateAdapter_SessionPersistenceManager_testcase extends Tx_PtExtlist_Tests_BaseTestcase {
	
	public function testSetup() {
		$sessionPersistenceManager = new Tx_PtExtlist_Domain_StateAdapter_SessionPersistenceManager();
	}
	
	
	
	public function testPersistToSession() {
		$persistableObjectStub = new Tx_PtExtlist_Tests_Domain_StateAdapter_Stubs_PersistableObject();
		$sessionPersistenceManager = Tx_PtExtlist_Domain_StateAdapter_SessionPersistenceManagerFactory::getInstance();
		$sessionPersistenceManager->persistToSession($persistableObjectStub);
	}
	
	
	
	public function testReloadFromSession() {
		$persistableObjectStub = new Tx_PtExtlist_Tests_Domain_StateAdapter_Stubs_PersistableObject();
        $sessionPersistenceManager = Tx_PtExtlist_Domain_StateAdapter_SessionPersistenceManagerFactory::getInstance();
        $persistableObjectStub->initSomeData();
        $sessionPersistenceManager->persistToSession($persistableObjectStub);
        
        $reloadedPersistableObject = new Tx_PtExtlist_Tests_Domain_StateAdapter_Stubs_PersistableObject();
        $sessionPersistenceManager->loadFromSession($reloadedPersistableObject);
        $this->assertTrue($reloadedPersistableObject->dummyData['testkey1'] == 'testvalue1');
	}
	
}
?>