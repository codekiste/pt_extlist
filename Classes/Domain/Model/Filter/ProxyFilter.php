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
 * Class implements an proxy filter to get data from a filter of an other list
 * 
 * @author Daniel Lienert <lienert@punkt.de>
 * @package Domain
 * @subpackage Model\Filter
 */
abstract class Tx_PtExtlist_Domain_Model_Filter_ProxyFilter extends Tx_PtExtlist_Domain_Model_Filter_AbstractFilter {
	
	
	/**
	 * Holds identifier of field that should be filtered
	 *
	 * @var Tx_PtExtlist_Domain_Configuration_Data_Fields_FieldConfig
	 */
	protected $fieldIdentifier;
	
	protected $proxyList;
	
	protected $proxyFilterBox;
	
	protected $proxyFilterIdentifier;
	
	protected $proxyFilterClass;
	
	/**
	 * @see Tx_PtExtlist_Domain_Model_Filter_AbstractFilter::initFilter()
	 */
	protected function initFilter() {}

	
	
	/**
	 * @see Tx_PtExtlist_Domain_Model_Filter_AbstractFilter::createFilterCriteria()
	 */
	protected function buildFilterCriteria() {}
	
	
	/**
	 * (non-PHPdoc)
	 * @see Classes/Domain/Model/Filter/Tx_PtExtlist_Domain_Model_Filter_AbstractFilter::setActiveState()
	 */
	protected function setActiveState() {}
	
	
	/**
	 * @see Tx_PtExtlist_Domain_Model_Filter_AbstractFilter::initFilterByGpVars()
	 *
	 */
	protected function initFilterByGpVars() {}
	
	
	
	/**
	 * @see Tx_PtExtlist_Domain_Model_Filter_AbstractFilter::initFilterBySession()
	 *
	 */
	protected function initFilterBySession() {}
	
	
	
	/**
	 * @see Tx_PtExtlist_Domain_Model_Filter_AbstractFilter::initFilterByTsConfig()
	 *
	 */
	protected function initFilterByTsConfig() {
		$filterSettings = $this->filterConfig->getSettings();
		tx_pttools_assert::isNotEmptyString($filterSettings['proxyPath'], array('message' => 'No proxy path to the proxy filter set. 1288033657'));
		
		
	}
}