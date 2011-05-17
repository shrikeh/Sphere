<?php
/**
 * Class for creating rationals
 * @category		Sphere
 * @package       	Sphere_Node
 * @subpackage		Rational
 * @copyright     	Copyright (c) 2009 Barney Hanlon (http://www.shrikeh.net)
 * @author        	B Hanlon <Barney_Hanlon@dennis.co.uk>
 * @version       	Revision $LastChangedRevision$ by $LastChangedBy$ on $LastChangedDate$  
 * @access        	public
 */

namespace Sphere\Node;
use Sphere\Node\Rational\RationalInterface as RationalInterface;
/**
 * Class for creating rationals
 * @category        Sphere
 * @package         Sphere_Node
 * @subpackage      Rational
 * @copyright       Copyright (c) 2009 Barney Hanlon (http://www.shrikeh.net)
 * @author          B Hanlon <Barney_Hanlon@dennis.co.uk>
 * @version         Revision $LastChangedRevision$ by $LastChangedBy$ on $LastChangedDate$  
 * @access          public
 */

class Rational implements RationalInterface
{
	protected $_numer;
	protected $_denom;
	
	
	/**
	 * Factory pattern
	 * 
	 * @param integer $numer
	 * @param integer $denom
	 */
	public static function factory($numer, $denom)
	{
		return new self($numer, $denom);
	}
	
	/**
	 * Take a string and return a Sphere_Node_Rational from it
	 * @param string $path
	 * @return Sphere_Node_Rational
	 */
	public static function fromPath($path, $separator = '.')
	{
	    $parts = array_reverse(explode($separator, ltrim($path)));
	    // test path of 2.4.3 (should be 65 / 23)
	    $denom = 1; 
	    while ($step = each($parts)) {
	        $numer = ($step / $denom);
	    }
	    
        //return self::_fromPath
	}
	
	protected static function _fromPath($path, $collapse = false, $separator = '.')
	{
 
	}
	
	public static function toPath(Rational $rational, $separator = '.')
	{
		$numer = $rational->getNumer();
		$denom = $rational->getDenom();
		$return = self::_toPath($numer, $denom);
		//die($return);
		return $return;
		
	}
	
	
	/**
	 * 
	 * Takes
	 * @param integer $numer
	 * @param integer $denom
	 * @param string $separator
	 */
	
	protected static function _toPath($numer, $denom, $separator = '.')
	{
	    
        //$numer = 48;
        // $denom = 17;	    
	    /**
         * 2.4.2 = 48/17
         */
        
        $path = '';
        
        
        while ( ($numer > 0) && ($denom > 0) )  {

            $div    = floor($numer / $denom);
            $mod    = $numer % $denom;
            

            $path.= $separator . $div;
            
            //echo "\n($ancnv : $ancdv) : ($ancsnv : $ancsdv) : $div : $mod\n";
            
            $numer = $mod;
            if ($numer) {
                
                if (!( $denom = ($denom % $mod)) ) {
                    $denom = 1;
                }
            }
        }
        return $path;	    
	}
	
	
	/**
	 * 
	 * Constructor.
	 * @param integer $numer The numerator
	 * @param integer $denom The denominator
	 */
	public function __construct($numer, $denom)
	{
		$this->setNumer($numer);
		$this->setDenom($denom);
	}
	
	/**
	 * 
	 * Get the path of the rational
	 * @param string $separator
	 * @return string
	 */
	public function getPath($separator = '.')
	{
		return strval(self::toPath($this, $separator));
	}
	
	
	protected function _getStep()
	{
		return floor($this->getNumer() / $this->getDenom());
	}
	
	/**
	 * 
	 * Return the value of numerator / denominator
	 * @return double
	 */
    public function toValue()
    {
        return (double) $this->_numer / $this->_denom;
    }
    
	/**
	 * 
	 * To string method to render the path.
	 */
	public function __toString()
	{
		return (string) $this->getNumer() . '/' . (string) $this->getDenom();
	}
	
	
	/**
	 * Return the numerator
	 * @return integer
	 */
	public function getNumer()
	{
		return $this->_numer;
	}
	
	/**
	 * Set the numerator
	 * @param integer $numer 
	 */
	public function setNumer($numer)
	{
		$this->_numer = (int) $numer;
	}
	
	/**
	 * Get the denominator
	 * @return integer
	 */
	public function getDenom()
	{
		return $this->_denom;
	}
	
	/**
	 * Set the denominator
	 * @param integer $denom
	 */
	public function setDenom($denom)
	{
		$this->_denom	= (int) $denom;
	}
	
	/**
	 * return if the passed Rational = exactly the value of this Rational
	 * @param Sphere_Node_Rational_RationalInterface $rational
	 * @return boolean
	 */
	public function match(RationalInterface $rational)
	{
		return ( ($this->getNumer() * $rational->getDenom()) - ($this->getDenom * $rational->getNumer()) );
	}
	

}