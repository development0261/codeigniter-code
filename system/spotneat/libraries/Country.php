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
 * Country Class
 *
 * @category       Libraries
 * @package        SpotnEat\Libraries\Country.php
 * @link           http://docs.spotneat.com
 */
class Country {

	public function addressFormat($address = array()) {
		if (!empty($address) AND is_array($address)) {
			if (!empty($address['format'])) {
				$format = $address['format'];
			} else {
				$format = '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{state}' . "\n" . '{country}';
			}

			$find = array(
				'{address_1}',
				'{address_2}',
				'{city}',
				'{postcode}',
				'{state}',
				'{country}'
			);

			$replace = array(
				'address_1' 	=> (isset($address['address_1'])) ? $address['address_1'] : '',
				'address_2' 	=> (isset($address['address_2'])) ? $address['address_2'] : '',
				'city'      	=> (isset($address['city'])) ? $address['city'] : '',
				'postcode'  	=> (isset($address['postcode'])) ? $address['postcode'] : '',
				'state'     	=> (isset($address['state'])) ? $address['state'] : '',
				'country' 		=> (isset($address['country'])) ? $address['country'] : ''
			);

			return str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));
		}
	}
	public function addressFormatAR($address = array()) {
		if (!empty($address) AND is_array($address)) {
			if (!empty($address['format'])) {
				$format = $address['format'];
			} else {
				$format = '{address_1_ar}' . "\n" . '{address_2_ar}' . "\n" . '{city_ar} {postcode}' . "\n" . '{state_ar}' . "\n" . '{country}';
			}

			$find = array(
				'{address_1_ar}',
				'{address_2_ar}',
				'{city_ar}',
				'{postcode}',
				'{state_ar}',
				'{country}'
			);

			$replace = array(
				'address_1_ar' 	=> (isset($address['address_1_ar'])) ? $address['address_1_ar'] : '',
				'address_2_ar' 	=> (isset($address['address_2_ar'])) ? $address['address_2_ar'] : '',
				'city_ar'      	=> (isset($address['city_ar'])) ? $address['city_ar'] : '',
				'postcode_ar'  	=> (isset($address['postcode_ar'])) ? $address['postcode_ar'] : '',
				'state_ar'     	=> (isset($address['state_ar'])) ? $address['state_ar'] : '',
				'country' 		=> (isset($address['country'])) ? $address['country'] : ''
			);

			return str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));
		}
	}
}
// END Country Class

/* End of file Country.php */
/* Location: ./system/spotneat/libraries/Country.php */