<?php

namespace chepe263;

class AlphaID
{
/**
 *
 * @author  Kevin van Zonneveld <kevin@vanzonneveld.net>
 * @author  Simon Franz
 * @author  Deadfish
 * @copyright 2008 Kevin van Zonneveld (http://kevin.vanzonneveld.net)
 * @license   http://www.opensource.org/licenses/bsd-license.php New BSD Licence
 * @version   Jan 03 2014 f36fc7b0a3c8b989e90a960a210675f6ed8fc492
 * @link    http://kevin.vanzonneveld.net/
 * @link    https://github.com/kvz/deprecated/blob/kvzlib/php/functions/alphaID.inc.php
 *
 * @param mixed   $in    String or long input to translate
 * @param boolean $to_num  Reverses translation when true
 * @param mixed   $pad_up  Number or boolean padds the result up to a specified length
 * @param string  $pass_key Supplying a password makes it harder to calculate the original ID
 *
 * @return mixed string or long
 */
	public static function make($in, $to_num = false, $pad_up = false, $pass_key = null)
	{
		$out   =   '';
		$index = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$base  = strlen($index);
		if ($pass_key !== null) {
			// Although this function's purpose is to just make the
			// ID short - and not so much secure,
			// with this patch by Simon Franz (http://blog.snaky.org/)
			// you can optionally supply a password to make it harder
			// to calculate the corresponding numeric ID
			for ($n = 0; $n < strlen($index); $n++) {
				$i[] = substr($index, $n, 1);
			}
			$pass_hash = hash('sha256',$pass_key);
			$pass_hash = (strlen($pass_hash) < strlen($index) ? hash('sha512', $pass_key) : $pass_hash);
			for ($n = 0; $n < strlen($index); $n++) {
				$p[] =  substr($pass_hash, $n, 1);
			}
			array_multisort($p, SORT_DESC, $i);
			$index = implode($i);
		}
		if ($to_num) {
			// Digital number  <<--  alphabet letter code
			$len = strlen($in) - 1;
			for ($t = $len; $t >= 0; $t--) {
				$bcp = bcpow($base, $len - $t);
				$out = $out + strpos($index, substr($in, $t, 1)) * $bcp;
			}
			if (is_numeric($pad_up)) {
				$pad_up--;
				if ($pad_up > 0) {
					$out -= pow($base, $pad_up);
				}
			}
		} else {
			// Digital number  -->>  alphabet letter code
			if (is_numeric($pad_up)) {
				$pad_up--;
				if ($pad_up > 0) {
					$in += pow($base, $pad_up);
				}
			}
			for ($t = ($in != 0 ? floor(log($in, $base)) : 0); $t >= 0; $t--) {
				$bcp = bcpow($base, $t);
				$a   = floor($in / $bcp) % $base;
				$out = $out . substr($index, $a, 1);
				$in  = $in - ($a * $bcp);
			}
		}
		return $out;
	}    
        
}
