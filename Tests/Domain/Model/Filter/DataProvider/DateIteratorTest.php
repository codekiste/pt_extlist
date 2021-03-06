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
use TYPO3\CMS\Core\Utility\ArrayUtility;

/**
 * Testcase for abstract groupDataFilter class
 *
 * @package Tests
 * @subpackage Somain\Model\Filter\DataProvider
 * @author Daniel Lienert 
 */
class Tx_PtExtlist_Tests_Domain_Model_Filter_DataProvider_DateIteratorTest extends Tx_PtExtlist_Tests_BaseTestcase
{
    protected $defaultFilterSettings = [
               'filterIdentifier' => 'timeSpanTest',
               'filterClassName' => 'Tx_PtExtlist_Domain_Model_Filter_TimeSpanFilter',
               'partialPath' => 'Filter/Options/TimeSpanFilter',
               'fieldIdentifier' => 'field1',
               'invert' => '0',
                    'dateIteratorStart' => '1227999510',
                    'dateIteratorEnd' =>   '1314607478',
                    'dateIteratorIncrement' => 'm',
                    'dateIteratorFormat' => '%m',
    ];
    
    
    
    public function setup()
    {
        $this->initDefaultConfigurationBuilderMock();
    }



    public function settingsDataProvider()
    {
        return [
            'incrementMonth' => [
                'settings' => [
                    'dateIteratorStart' => mktime(0, 0, 0, 1, 1, 2011),
                    'dateIteratorEnd' => mktime(0, 0, 0, 12, 31, 2011),
                    'dateIteratorIncrement' => 'm',
                    'dateIteratorFormat' => '%m.%Y',
                ],
                'result' => [
                    'count' => 12,
                    'firstRendered' => '01.2011',
                    'lastRendered' => '12.2011',
                    'rangeArray' => ['1293836400,1296514800','1296514800,1298934000','1298934000,1301608800','1301608800,1304200800','1304200800,1306879200','1306879200,1309471200','1309471200,1312149600','1312149600,1314828000','1314828000,1317420000','1317420000,1320102000','1320102000,1322694000','1322694000,1325372400']
                ]
            ]
        ];
    }



    public function incorrectSettingsDataProvider()
    {
        return [
            'NoStartDateGiven' => [
                'settings' => [
                    'dateIteratorStart' => '',
                    'dateIteratorEnd' => '1314607478',
                    'dateIteratorIncrement' => 'm',
                    'dateIteratorFormat' => '%m',
                ]
            ],
            'NoEndDateGiven' => [
                'settings' => [
                    'dateIteratorStart' => '1227999510',
                    'dateIteratorEnd' => '',
                    'dateIteratorIncrement' => 'm',
                    'dateIteratorFormat' => '%m',
                ]
            ],
            'NoIncrementGiven' => [
                'settings' => [
                    'dateIteratorStart' => '1227999510',
                    'dateIteratorEnd' => '1314607478',
                    'dateIteratorIncrement' => '',
                    'dateIteratorFormat' => '%m',
                ]
            ],
            'NoFormatGiven' => [
                'settings' => [
                    'dateIteratorStart' => '1227999510',
                    'dateIteratorEnd' => '1314607478',
                    'dateIteratorIncrement' => 'm',
                    'dateIteratorFormat' => '',
                ]
            ],
            'EndDateIsBeforeStartDate' => [
                'settings' => [
                    'dateIteratorStart' => '1314607478',
                    'dateIteratorEnd' => '1227999510',
                    'dateIteratorIncrement' => 'm',
                    'dateIteratorFormat' => '%m',
                ]
            ],
            'IncrementSettingUnknown' => [
                'settings' => [
                    'dateIteratorStart' => '1314607478',
                    'dateIteratorEnd' => '1227999510',
                    'dateIteratorIncrement' => 'X',
                    'dateIteratorFormat' => '%m',
                ]
            ]
        ];
    }



    /**
     * @test
     */
    public function settingsAreInjectedAndSet()
    {
        $dataProvider = $this->buildAccessibleDateIteratorDataProvider();

        $this->assertEquals($this->defaultFilterSettings['dateIteratorStart'], $dataProvider->_get('dateIteratorStart'));
        $this->assertEquals($this->defaultFilterSettings['dateIteratorEnd'], $dataProvider->_get('dateIteratorEnd'));
        $this->assertEquals($this->defaultFilterSettings['dateIteratorIncrement'], $dataProvider->_get('dateIteratorIncrement'));
        $this->assertEquals($this->defaultFilterSettings['dateIteratorFormat'], $dataProvider->_get('dateIteratorFormat'));
    }



    /**
     * @test
     * @dataProvider incorrectSettingsDataProvider
     */
    public function initThrowsExceptionOnConfigurationError($settings)
    {
        $filterSettings = $this->defaultFilterSettings;
        ArrayUtility::mergeRecursiveWithOverrule($filterSettings, $settings);

        try {
            $dataProvider = $this->buildAccessibleDateIteratorDataProvider($filterSettings);
        } catch (Exception $e) {
            return;
        }

        $this->fail('No Exception thrown!');
    }



    /**
     * @test
     * @dataProvider settingsDataProvider
     */
    public function getRenderedOptions($settings, $result)
    {
        $filterSettings = $this->defaultFilterSettings;
        ArrayUtility::mergeRecursiveWithOverrule($filterSettings, $settings);

        $dataProvider = $this->buildAccessibleDateIteratorDataProvider($filterSettings);

        $resultArray = $dataProvider->getRenderedOptions();
        $this->assertEquals($result['count'], count($resultArray), 'The result array should contain ' . $result['count'] . ' Items, but we got ' .  count($resultArray));
    }
    
    
    
    /**
     * @test
     * @dataProvider settingsDataProvider
     */
    public function buildTimeStampList($settings, $result)
    {
        $filterSettings = $this->defaultFilterSettings;
        ArrayUtility::mergeRecursiveWithOverrule($filterSettings, $settings);

        $dataProvider = $this->buildAccessibleDateIteratorDataProvider($filterSettings);
        $resultArray = $dataProvider->_call('buildTimeStampList');

        $this->assertEquals($result['count'], count($resultArray), 'The result array should contain ' . $result['count'] . ' Items, but we got ' .  count($resultArray));

        $i =0;
        foreach ($resultArray as $range => $renderValue) {
            $this->assertEquals($range, $result['rangeArray'][$i], 'Range ' . $i . 'differs from test value');
            $i++;
        }

        reset($resultArray);
        $this->assertEquals($result['firstRendered'], strftime($settings['dateIteratorFormat'], current($resultArray)));
        $this->assertEquals($result['lastRendered'], strftime($settings['dateIteratorFormat'], end($resultArray)));
    }

    
    

    /**
     * @param $filterSettings
     * @return Tx_PtExtlist_Domain_Model_Filter_DataProvider_DateIterator
     */
    protected function buildAccessibleDateIteratorDataProvider($filterSettings = null)
    {
        if (!$filterSettings) {
            $filterSettings = $this->defaultFilterSettings;
        }

        $accessibleClassName = $this->buildAccessibleProxy('Tx_PtExtlist_Domain_Model_Filter_DataProvider_DateIterator');
        $accessibleTimeSpanDataProvider = new $accessibleClassName; /* @var $accessibleTimeSpanDataProvider Tx_PtExtlist_Domain_Model_Filter_DataProvider_DataProviderInterface */

        $filterConfiguration = new Tx_PtExtlist_Domain_Configuration_Filters_FilterConfig($this->configurationBuilderMock, $filterSettings, 'test');

        $accessibleTimeSpanDataProvider->_injectFilterConfig($filterConfiguration);
        $accessibleTimeSpanDataProvider->init();

        return $accessibleTimeSpanDataProvider;
    }
}
