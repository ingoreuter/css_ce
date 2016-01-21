<?php
namespace ingoreuter\CssCe\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Ingo Reuter <mail@ingoreuter>
 *  
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
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



//ini_set('display_errors',1);
//ini_set('display_startup_errors',1);
//error_reporting(E_ALL);



/**
 *
 *
 * @package css_ce
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class CssController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * contentElementRepository
	 *
	 * @var \ingoreuter\CssCe\Domain\Repository\ContentElementRepository
	 * @inject
	 */
	protected $ContentElementRepository;

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		
		/** @var \TYPO3\CMS\Extbase\Service\FlexFormService */
		$flexForm = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance("TYPO3\CMS\Extbase\Service\FlexFormService");
		
		$cssCode = array();
		$moreCss = array();
		$freeCss = array();
		$mediaQuery = array();
		$printRules = array();
		$checkStr = array();
			
		$contentElementList = $this->ContentElementRepository->findAllOnPage();
		$contentElementArray = $contentElementList->toArray();
		
		foreach($contentElementArray as $contentElement) {
			$cssContent = $contentElement->getCssContent();
			$cssContentArray = \TYPO3\CMS\Extbase\Service\FlexFormService::convertFlexFormContentToArray($cssContent);
			
			$temp = "";
			$uid = $contentElement->getUid();
			$uid = $contentElement->_getProperty('_localizedUid');
			for($i = 0; list($prop, $value) = each($cssContentArray['contentelement']); $i++) {
				$cssCode[$uid][$i]['prop'] = $prop;
				$cssCode[$uid][$i]['value'] = $value;
				if($cssCode[$uid][$i]['prop'] == "background-image") {
					$cssCode[$uid][$i]['value'] = "url(http://" . \TYPO3\CMS\Core\Utility\GeneralUtility::getHostname() . "/uploads/tx_cssce/backgroundimages/" . $cssCode[$uid][$i]['value'] . ")";
				}

				$temp .= $value;
			}
			$temp .= $cssContentArray['other']['ce'];
			$checkStr[$uid] = $temp;
			$moreCss[$uid] = $cssContentArray['other']['ce'];
			
			if($cssContentArray['rwd']['mode'] == "hide") {
				$sizes = explode(",", $cssContentArray['rwd']['screensize']);
				
				if(in_array("xs", $sizes)) {
					$mediaQuery[$uid] .= ($mediaQuery[$uid] == "") ? "@media " : ", ";
					$mediaQuery[$uid] .= "screen AND (max-width: " . ($this->settings['widthS']-1)  ."px)";
				}
				if(in_array("s", $sizes)) {
					$mediaQuery[$uid] .= ($mediaQuery[$uid] == "") ? "@media " : ", ";
					$mediaQuery[$uid] .= "screen AND (min-width: " . ($this->settings['widthS'])  ."px) AND (max-width: " .( $this->settings['widthM']-1)  ."px)";
				}
				if(in_array("m", $sizes)) {
					$mediaQuery[$uid] .= ($mediaQuery[$uid] == "") ? "@media " : ", ";
					$mediaQuery[$uid] .= "screen AND (min-width: " . ($this->settings['widthM'])  ."px) AND (max-width: " . ($this->settings['widthL']-1)  ."px)";
				}
				if(in_array("l", $sizes)) {
					$mediaQuery[$uid] .= ($mediaQuery[$uid] == "") ? "@media " : ", ";
					$mediaQuery[$uid] .= "screen AND (min-width: " . ($this->settings['widthL'])  ."px)";
				}
			}
			
			if($cssContentArray['rwd']['print']) {
				$printRules[$uid] = true;
			}
			
			$freeCss[] = $cssContentArray['other']['page'];
		}
		$this->view	->assign('cssCode', $cssCode)
					->assign('moreCss', $moreCss)
					->assign('rwd', $mediaQuery)
					->assign('print', $printRules)
					->assign('freeCss', $freeCss)
					->assign('checkStr', $checkStr);
	}
}
?>