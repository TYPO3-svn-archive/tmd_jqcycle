<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Christian Tauscher <cms@media-distillery.de>
*  All rights reserved
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
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 * Hint: use extdeveval to insert/update function index above.
 * 
 * http://malsup.com/jquery/
 */

require_once(PATH_tslib.'class.tslib_pibase.php');

/**
 * Plugin 'jQuery Image-Cycle' for the 'tmd_jqcycle' extension.
 *
 * @author	Christian Tauscher <cms@media-distillery.de>
 * @package	TYPO3
 * @subpackage	tx_tmdjqcycle
 */
class tx_tmdjqcycle_pi1 extends tslib_pibase {
	var $prefixId      = 'tx_tmdjqcycle_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_tmdjqcycle_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'tmd_jqcycle';	// The extension key.
	var $uploadPath    = 'uploads/tx_tmdjqcycle/'; 
	var $pi_checkCHash = true;
	
	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	function main($content, $conf) {
		$this->conf = $conf;
		#$this->pi_setPiVarDefaults();
		$this->pi_loadLL();
		$this->pi_initPIflexForm();

		
		
			// checks if t3jquery is loaded
		if (t3lib_extMgm::isLoaded('t3jquery')) {
		    require_once(t3lib_extMgm::extPath('t3jquery').'class.tx_t3jquery.php');
		} else {
			return "Error: t3jquery fehlt!";
		}
		// if t3jquery is loaded and the custom Library had been created
		tx_t3jquery::addJqJS();

			# JQuery Code kommt dazu.
			# Abhängig von EXT Konfiguration machen
		$GLOBALS['TSFE']->additionalHeaderData[$ext_key] = '<script src="'.t3lib_extMgm::siteRelPath($this->extKey).'res/jquery.cycle.all.min.js'.'" type="text/javascript"></script>';

				/* Konfiguration */
		$this->initFeature($this->option('feature' ,'s_configuration'));
		$config  = "$(document).ready(function() {
		    		$('#slideshow-".$this->param['id']."').cycle({";

			foreach($this->param as $key => $val) {
				$line[] = $key.': "'.$val.'"';
			}
			$config .= implode(',', $line);
		
		$config .= "	});
					});";

		$content = t3lib_div::wrapJS($config);

		$images = explode(',', $this->option('images', 's_image'));
		$this->conf['image.']['file.']['width']  = $this->option('width',  's_configuration');
		$this->conf['image.']['file.']['height'] = $this->option('height', 's_configuration');

		debug(array($this->param, $config, $this->conf, $images));
		
		foreach($images as $img) {
			$this->conf['image.']['file'] = $this->uploadPath.$img;
 			$files[] = $this->cObj->IMAGE($this->conf['image.']);
		}

		$content .='<div class="slideshows" id="slideshow-'.$this->param['id'].'">';
		$content .= implode(chr(13), $files);
		$content .= '</div>';

		return $this->pi_wrapInBaseClass($content);
	}

	
	
	
	function option($key, $sheet = '') {
		$value = $this->conf[$key];
		
		if($this->pi_getFFvalue($this->cObj->data['pi_flexform'], $key, $sheet))
			$value = $this->pi_getFFvalue($this->cObj->data['pi_flexform'], $key, $sheet);
		
		
		return $value;
	}

	
	function initFeature($value) {
		 switch ($value) {
			case '2': $value='blindX'; break;
			case '3': $value='blindY'; break;
			case '4': $value='blindZ'; break;
			case '5': $value='cover'; break;
			case '6': $value='curtainX'; break;
			case '7': $value='curtainY'; break;
			case '8': 
				$this->param = array(
					"id" => rand(1000, 9999),
					"fx" => 'fade',
/*					"speed" => $this->option("speed", "s_configuration"), 
					"pause" => $this->option("pause", "s_configuration"),
					"random" => $this->option("random", "s_configuration"), 
*/					);
			break;
			case '9': $value='fadeZoom'; break;
			case '10': $value='growX'; break;
			case '11': $value='growY'; break;
			case '12': $value='scrollUp'; break;
			case '13': 
				$this->param = array(
					"id" => rand(1000, 9999),
					"fx" => 'scrollDown',
					"speed" => $this->option("speed", "s_configuration"), 
					"timeout" => $this->option("timeout", "s_configuration"),
					"pause" => $this->option("pause", "s_configuration"),
					"random" => $this->option("random", "s_configuration"), 
					);
			break;
			case '14': $value='scrollLeft'; break;
			case '15': $value='scrollRight'; break;
			case '16': $value='scrollHorz'; break;
			case '17': $value='scrollVert'; break;
			case '18':  
				$this->param = array(
					"id" => rand(1000, 9999),
					"fx" => 'shuffle',
					"delay" => -$this->option("delay", "s_configuration"), 
#					"timeout" => $this->option("timeout", "s_configuration"),
					"pause" => $this->option("pause", "s_configuration"),
#					"random" => $this->option("random", "s_configuration"), 
					);
			break;
			case '19':
				$this->param = array(
					"id" => rand(1000, 9999),
					"fx" => 'slideX',
					);
			break;
			case '20': 
				$this->param = array(
					"id" => rand(1000, 9999),
					"fx" => 'slideY',
					"speed" => $this->option("speed", "s_configuration"),
					"timeout" => $this->option("timeout", "s_configuration"),
				);
				$this->param['next'] = '#slideshow-'.$this->param['id'];
			break;
			case '21': $value='toss'; break;
			case '22': $value='turnUp'; break;
			case '23': $value='turnDown'; break;
			case '24': $value='turnLeft'; break;
			case '25': $value='turnRight'; break;
			case '26': $value='uncover'; break;
			case '27': $value='wipe'; break;
			case '28': 
				$this->param = array(
					"id" => rand(1000, 9999),
					"fx" => 'zoom',
					"sync" => $this->option("sync", "s_configuration"), 
#					"timeout" => $this->option("timeout", "s_configuration"),
#					"pause" => $this->option("pause", "s_configuration"),
#					"random" => $this->option("random", "s_configuration"), 
					);
			break;
		}

	}
	
}




if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/tmd_jqcycle/pi1/class.tx_tmdjqcycle_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/tmd_jqcycle/pi1/class.tx_tmdjqcycle_pi1.php']);
}
?>