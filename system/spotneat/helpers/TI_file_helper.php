<?php
/**
 * SpotnEat
 *
 * 
 *
 * @package   SpotnEat
 * @author    Sp
 * @copyright SpotnEat
 * @link      http://spotneat.com
 * @license   http://spotneat.com
 * @since     File available since Release 1.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * File helper functions
 *
 * @category       Helpers
 * @package        SpotnEat\Helpers\TI_file_helper.php
 * @link           http://docs.spotneat.com
 */

if ( ! function_exists('unzip_file'))
{
	/**
	 * Unzip File
	 *
	 * @param      $file
	 * @param null $extractTo
	 *
	 * @return string
	 */
	function unzip_file($file, $extractTo = NULL)
	{
		if ( ! class_exists('ZipArchive')) return FALSE;

		$zip = new ZipArchive;

		(!empty($extractTo)) OR $extractTo = dirname($file);

		if ( ! file_exists($file)) return FALSE;

		chmod($file, 0777);

		if ($zip->open($file) === TRUE) {
			$dirname = trim($zip->getNameIndex(0), '/');

			$zip->extractTo($extractTo);
			$zip->close();

			return $dirname;
		} else {
			return FALSE;
		}
	}
}

/* End of file TI_file_helper.php */
/* Location: ./system/spotneat/helpers/TI_file_helper.php */