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
 * Currency Class
 *
 * @category       Libraries
 * @package        SpotnEat\Libraries\Currency.php
 * @link           http://docs.spotneat.com
 */
class Currency {

	private $currency_id;
	private $currencies = array();

	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->database();

		$this->CI->db->from('currencies');
		$query = $this->CI->db->get();

		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$this->currencies[$row['currency_id']] = array(
					'currency_id'      => $row['currency_id'],
					'country_id'       => $row['country_id'],
					'currency_code'    => $row['currency_code'],
					'currency_name'    => $row['currency_name'],
					'currency_symbol'  => $row['currency_symbol'],
					'symbol_position'  => $row['symbol_position'],
					'thousand_sign'    => $row['thousand_sign'],
					'decimal_sign'     => $row['decimal_sign'],
					'decimal_position' => $row['decimal_position'],
					'flag'             => $row['flag'],
					'currency_status'  => $row['currency_status'],
				);
			}
		}

		$this->currency_id = $this->CI->config->item('currency_id');
	}

	public function getCurrencyCode() {
		return ( ! isset($this->currencies[$this->currency_id]['currency_code'])) ? 'USD' : $this->currencies[$this->currency_id]['currency_code'];
	}

	public function getCurrencySymbol() {
		return ( ! isset($this->currencies[$this->currency_id]['currency_symbol'])) ? 'USD' : $this->currencies[$this->currency_id]['currency_symbol'];
	}


	public function getCurrencyExchange($currency) {
		 	$this->CI->db->select('currency_rate');
            $this->CI->db->from('currencies');
            $this->CI->db->where('currency_code', $currency);
            $query = $this->CI->db->get();

            if ($query->num_rows() > 0) {
                $row = $query->row_array();
                $currency_rate = $row['currency_rate'];
            }
            return $currency_rate;
	}

	public function format($number, $currency = '', $format = TRUE) {
		$currency = empty($currency) ? $this->currency_id : $currency;

		$currency_symbol = ! isset($this->currencies[$currency]['currency_symbol']) ? '&pound;' : $this->currencies[$currency]['currency_symbol'];
		$symbol_position = ! isset($this->currencies[$currency]['symbol_position']) ? '0' : $this->currencies[$currency]['symbol_position'];
		$thousand_sign = ! isset($this->currencies[$currency]['thousand_sign']) ? ',' : $this->currencies[$currency]['thousand_sign'];
		$decimal_sign = ! isset($this->currencies[$currency]['decimal_sign']) ? '.' : $this->currencies[$currency]['decimal_sign'];
		$decimal_position = ! isset($this->currencies[$currency]['decimal_position']) ? 2 : (int)$this->currencies[$currency]['decimal_position'];

		$number = ! empty($number) ? $number : '0';

		$number = round((float)$number, $decimal_position);

		$string = number_format($number, $decimal_position, $decimal_sign, $thousand_sign);

		if ($format) {
			if ($symbol_position === '1') {
				$string = $string.' '. $currency_symbol;
			} else {
				$string = $currency_symbol.' '.$string;
			}
		}

		return $string;
	}
}

// END Currency Class

/* End of file Currency.php */
/* Location: ./system/spotneat/libraries/Currency.php */