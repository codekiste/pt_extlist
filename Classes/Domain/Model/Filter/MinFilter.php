<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Daniel Lienert <lienert@punkt.de>, Michael Knoll <knoll@punkt.de>,
*  Christoph Ehscheidt <ehscheidt@punkt.de>
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
 * @author Christoph Ehscheidt <ehscheidt@punkt.de>
 * @package Domain
 * @subpackage Filter
 */
class Tx_PtExtlist_Domain_Model_Filter_MinFilter extends Tx_PtExtlist_Domain_Model_Filter_AbstractSingleValueFilter {
 	
 	/**
     * (non-PHPdoc)
     * @see Classes/Domain/Model/Filter/Tx_PtExtlist_Domain_Model_Filter_AbstractFilter#initFilter()
     */
    protected function initFilter() {
    	
    	$this->isActive = !empty($this->filterValue) ? true : false;     	
    }
    
    
    
    /**
     * Creates filter query from filter value and settings
     */
    protected function buildFilterCriteria() {
    	if($this->isActive) {
    		$columnName = $this->fieldIdentifier->getTableFieldCombined();
    		$filterValue = intval($this->filterValue);
	    	$criteria = Tx_PtExtlist_Domain_QueryObject_Criteria::greaterThanEquals($columnName, $filterValue);	
    	}
    	
    	return $criteria;
    }	
    
    
    
    public function validate() {
    	$validation = $this->filterConfig->getSettings('validation');
    	
    	if(!$this->isActive) return 1;

    	if(array_key_exists('maxValue', $validation) 
    		&& intval($this->filterValue) > $validation['maxValue']) {
    			
    			$this->errorMessage = 'Value is not allowed to be bigger than '.$validation['maxValue'];
    			return 0;
    	}
    	
    	if(array_key_exists('minValue', $validation) 
    		&& intval($this->filterValue) < $validation['minValue']) {
    			$this->errorMessage = 'Value is not allowed to be smaller than '.$validation['minValue'];
    			return 0;
    	}
    	
    	return 1;
    }
}

?>