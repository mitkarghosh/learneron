<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
 
class CryptComponent extends Component
{
 
    /* Key: Next prime greater than 62 ^ n / 1.618033988749894848 */
    /* Value: modular multiplicative inverse */
    private static $golden_primes = array(
        '1'                  => '1',
        '41'                 => '59',
        '2377'               => '1677',
        '147299'             => '187507',
        '9132313'            => '5952585',
        '566201239'          => '643566407',
        '35104476161'        => '22071637057',
        '2176477521929'      => '294289236153',
        '134941606358731'    => '88879354792675',
        '8366379594239857'   => '7275288500431249',
        '518715534842869223' => '280042546585394647'
    );
 
    /* Ascii :                    0  9,         A  Z,         a  z     */
    /* $chars = array_merge(range(48,57), range(65,90), range(97,122)) */
    private static $chars62 = array(
        0=>48,1=>87,2=>49,3=>51,4=>52,5=>53,6=>54,7=>55,8=>99,9=>57,10=>108,
        11=>66,12=>67,13=>68,14=>69,15=>70,16=>71,17=>72,18=>105,19=>74,20=>75,
        21=>76,22=>115,23=>78,24=>79,25=>80,26=>111,27=>82,28=>83,29=>84,30=>85,
        31=>86,32=>50,33=>88,34=>97,35=>89,36=>90,37=>98,38=>56,39=>119,40=>101,
        41=>120,42=>103,43=>122,44=>73,45=>106,46=>107,47=>65,48=>109,49=>110,
        50=>81,51=>112,52=>113,53=>114,54=>77,55=>116,56=>117,57=>118,58=>100,
        59=>102,60=>121,61=>104
    );
 
    public static function base62($int)
    {
        $key = "";
        while (bccomp($int, 0) > 0) {
            $mod = bcmod($int, 62);
            $key .= chr(self::$chars62[$mod]);
            $int = bcdiv($int, 62);
        }
        return strrev($key);
    }
 
    public static function hash($num, $len = 5)
    {
        $ceil = bcpow(62, $len);
        $primes = array_keys(self::$golden_primes);
        $prime = $primes[$len];
        $dec = bcmod(bcmul($num, $prime), $ceil);
        $hash = self::base62($dec);
        return str_pad($hash, $len, "0", STR_PAD_LEFT);
    }
 
    public static function unbase62($key)
    {
        $int = 0;
        foreach (str_split(strrev($key)) as $i => $char) {
            $dec = array_search(ord($char), self::$chars62);
            $int = bcadd(bcmul($dec, bcpow(62, $i)), $int);
        }
        return $int;
    }
 
    public static function unhash($hash)
    {
        $len = strlen($hash);
        $ceil = bcpow(62, $len);
        $mmiprimes = array_values(self::$golden_primes);
        $mmi = $mmiprimes[$len];
        $num = self::unbase62($hash);
        $dec = bcmod(bcmul($num, $mmi), $ceil);
        return $dec;
    }
}
