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
 * Aufgaben des Mappers:
 * 
 * 1) Umwandeln der von der Datenquelle gelieferten Daten in die Listendatenstruktur
 * 
 * 2) Umwandeln der generischen Query in eine von der DB verstandenen Query, evtl. eigene Query Verarbeitung
 * 
 * => Der Mapper hat 2 Aufgaben
 * 
 * => Dieser sollte in zwei Klassen aufgeteilt werden!
 */

/**
 * Class implements a mapper that maps array data to list data structure for a given 
 * fields configuration.
 * 
 * @package Typo3
 * @subpackage pt_extlist
 * @author Michael Knoll <knoll@punkt.de>
 */
class Tx_PtExtlist_Domain_DataBackend_Mapper_ArrayMapper extends Tx_PtExtlist_Domain_DataBackend_Mapper_AbstractMapper {
    
	/**
	 * Holds mapping configurations
	 *
	 * @var Tx_PtExtlist_Domain_Configuration_Data_Fields_FieldConfigCollection
	 */
	protected $mapperConfiguration = null;
	
	
	
	/**
	 * Sets the mapper configuration
	 *
	 * @param Tx_PtExtlist_Domain_Configuration_Data_Fields_FieldConfigCollection $mapperConfiguration
	 */
	public function setMapperConfiguration(Tx_PtExtlist_Domain_Configuration_Data_Fields_FieldConfigCollection $mapperConfiguration) {
		$this->mapperConfiguration = $mapperConfiguration;
	}
	
	
	
	/**
	 * Maps given array data to list data structure.
	 * If no configuration is set, the array is mapped 1:1 to the list data structure
	 * If a configuration is given, this configuration is used to map the fields
	 *
	 * @param array $arrayData Raw data array to be mapped to list data structure
	 * @return Tx_PtExtlist_Domain_Model_List_ListData
	 */
	public function getMappedListData(array $arrayData) {
		if (is_null($this->mapperConfiguration)) {
			$mappedListData = $this->mapWithoutConfiguration($arrayData);
		} else {
		    $mappedListData = $this->mapWithConfiguration($arrayData);
		}
		return $mappedListData;
	}
	
	
	
	/**
	 * Maps raw list data with given mapper configuration.
	 *
	 * @param array $arrayData Raw array to be mapped
	 * @return Tx_PtExtlist_Domain_Model_List_ListData Mapped list data structure
	 */
	protected function mapWithoutConfiguration(array $arrayData) {
		$listData = new Tx_PtExtlist_Domain_Model_List_ListData();
		foreach ($arrayData as $row) {
			$mappedRow = new Tx_PtExtlist_Domain_Model_List_Row();
			foreach ($row as $fieldname => $value) {
				$mappedRow->addCell($fieldname, $value);
			}
			$listData->addRow($mappedRow);
		}
		return $listData;
	}
	
	
	
	/**
	 * Maps raw list data without any mapper configuration.
	 * Each field of the given raw array is mapped to
	 * a cell in the list data structure
	 *
	 * @param array $arrayData Raw array to be mapped
	 * @return Tx_PtExtlist_Domain_Model_List_ListData Mapped list data structure
	 */
	protected function mapWithConfiguration(array $arrayData) {
		$listData = new Tx_PtExtlist_Domain_Model_List_ListData();
		foreach($arrayData as $row) {
			$mappedRow = $this->mapRowWithConfiguration($row);
			$listData->addRow($mappedRow);
		}
		return $listData;
	}
	
	
	
	/**
	 * Maps a single row of a list data structure with given configuration.
	 *
	 * @param array $row   Row of raw list data array
	 * @return Tx_PtExtlist_Domain_Model_List_Row  Mapped row
	 */
	protected function mapRowWithConfiguration(array $row) {
		$mappedRow = new Tx_PtExtlist_Domain_Model_List_Row();
		foreach ($this->mapperConfiguration as $mapping) { /* @var $mapping Tx_PtExtlist_Domain_Configuration_Data_Fields_FieldConfig */
			$mappedCellValue = $this->getMappedCellValue($mapping, $row);
			$mappedRow->addCell($mapping->getIdentifier(), $mappedCellValue);
		}
		return $mappedRow;
	}
	
	
	
	/**
	 * Maps a field of raw data to a cell of a list data structure 
	 *
	 * @param Tx_PtExtlist_Domain_Configuration_Data_Fields_FieldConfig $mapping Mapping for this field / cell
	 * @param array $row   Raw row of list data array
	 * @return string  Value of raw data array field corresponding to given mapping
	 */
	protected function getMappedCellValue(Tx_PtExtlist_Domain_Configuration_Data_Fields_FieldConfig $mapping, array $row) {
		if (array_key_exists($mapping->getTable() . '.' . $mapping->getField(), $row)) {
			return $row[$mapping->getTable() . '.' . $mapping->getField()];
		} else {
			throw new Exception('Array key ' . $mapping->getTable() . '.' . $mapping->getField() . 'does not exist in row. Perhaps wrong mapping configuration?');
		}
	}
	
}

?>