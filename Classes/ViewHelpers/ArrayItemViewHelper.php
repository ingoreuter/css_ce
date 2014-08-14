<?php
namespace ingoreuter\CssCe\ViewHelpers;

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
 
 /**
 *
 * Example
 * {namespace oh=ingoreuter\OpeningHours\ViewHelpers}
 * <cc:arrayItem array="{theArray}" item="int" />
 *
 * @package ingoreuter
 * @subpackage css_ce
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class ArrayItemViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {
	/**
	  * Returns an Item of an Array
	  *
	  * @param \array $array the array
	  * @param int $item item's key
	  * @return \string items content
	  * @author Ingo Reuter <mail@ingoreuter.de>
	  */
	public function render($array, $item) {
		return $array[$item];
	}
}
 
 ?>