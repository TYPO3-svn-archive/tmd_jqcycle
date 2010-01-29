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

		$images = explode(',', $this->option('images', 's_image'));
		
		if(count($images) > 1) {
						
			// checks if t3jquery is loaded
			if (t3lib_extMgm::isLoaded('t3jquery')) {
			    require_once(t3lib_extMgm::extPath('t3jquery').'class.tx_t3jquery.php');
			}
			// if t3jquery is loaded and the custom Library had been created
			if (T3JQUERY === true) {
			    tx_t3jquery::addJqJS();
			} else {
				#return "Error: t3jquery fehlt2!";
				
			    // if none of the previous is true, you need to include your own library
			    // just as an example in this way
			    $GLOBALS['TSFE']->additionalHeaderData[$ext_key] = '<script src="'.$this->getPath($this->conf['pathToJquery']).'" type="text/javascript"></script>';
			}
			
			
			
			
			
			
			
			
				#JQuery-CYCLE Code kommt dazu.
			$GLOBALS['TSFE']->additionalHeaderData[$ext_key] = '<script src="'.t3lib_extMgm::siteRelPath($this->extKey).'res/jquery.cycle.all.min.js'.'" type="text/javascript"></script>';

					/* Konfiguration */
			$this->initFeature();
			$config  = "$(document).ready(function() {
			    		$('#slideshow-".$this->param['id']."').cycle({";


				if($this->option('useAdvanced',  's_advanced') != 1) {
					foreach($this->param as $key => $val) {
						$line[] = $key.': "'.$val.'"';
					}
					$config .= implode(',', $line);
				} else {
					$config .= $this->option('advanced',  's_advanced');
				}
				
			$config .= "	});
						});";

	
			$content = t3lib_div::wrapJS($config);
	
			$this->conf['image.']['file.']['width']  = $this->option('width',  's_configuration');
			$this->conf['image.']['file.']['height'] = $this->option('height', 's_configuration');
	
			foreach($images as $img) {
				$this->conf['image.']['file'] = $this->uploadPath.$img;
	 			$files[] = $this->cObj->IMAGE($this->conf['image.']);
			}
	
			$content .='<div class="slideshows" id="slideshow-'.$this->param['id'].'">';
			$content .= implode(chr(13), $files);
			$content .= '</div>';
		} else { # nur ein Bild vorhanden
			$this->conf['image.']['file'] = $this->uploadPath.$images[0];
			$this->conf['image.']['file.']['width']  = $this->option('width',  's_configuration');
			$this->conf['image.']['file.']['height'] = $this->option('height', 's_configuration');

			$content = $this->cObj->IMAGE($this->conf['image.']);
		}

		return $this->pi_wrapInBaseClass($content);
	}

	
	
	
	function option($key, $sheet = '') {
		$value = $this->conf[$key];
		
		if($this->pi_getFFvalue($this->cObj->data['pi_flexform'], $key, $sheet))
			$value = $this->pi_getFFvalue($this->cObj->data['pi_flexform'], $key, $sheet);
		
		if($key == 'images' && isset($this->conf['images.'])) {
				$value = $this->cObj->TEXT($this->conf['images.']);
		}
		
		return $value;
	}


	
	
	function initFeature() {
		$this->param = array(
			"id" => rand(1000, 9999),
			"fx" => 'fade',
			"width" 	=> $this->option("width", "s_configuration"),
			"height" 	=> $this->option("height", "s_configuration"),
			"timeout" 	=> $this->option("timeout", "s_configuration"),
			"speed" 	=> $this->option("speed", "s_configuration"),
			"speedIn" 	=> $this->option("speedIn", "s_configuration"),
			"speedOut" 	=> $this->option("speedOut", "s_configuration"),
			"random" 	=> $this->option("random", "s_configuration"),
			"sync" 		=> $this->option("sync", "s_configuration"),
			"pause" 	=> $this->option("pause", "s_configuration"),
			"delay" 	=> $this->option("delay", "s_configuration"),
			"continuous" => $this->option("continuous", "s_configuration"),
			);
	}

	
	
}




if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/tmd_jqcycle/pi1/class.tx_tmdjqcycle_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/tmd_jqcycle/pi1/class.tx_tmdjqcycle_pi1.php']);
}
?>