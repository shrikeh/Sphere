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

/** Sphere_Node_Rational_RationalInterface **/
//require_once('Sphere/Node/Rational/RationalInterface.php');
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

class Sphere_Node_Rational implements Sphere_Node_Rational_RationalInterface
{
	protected $_numer;
	protected $_denom;
	
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
	
	public static function toPath(Sphere_Node_Rational $rational, $separator = '.')
	{
		$numer = $rational->getNumer();
		$denom = $rational->getDenom();
		$return = self::_toPath($numer, $denom);
		//die($return);
		return $return;
		
	}
	
	

	
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
	
	public function __construct($numer, $denom)
	{
		$this->setNumer($numer);
		$this->setDenom($denom);
	}
	
	public function getPath($separator = '.')
	{
		return strval(self::toPath($this, $separator));
	}
	
	
	protected function _getStep()
	{
		return floor($this->getNumer() / $this->getDenom());
	}
	
	
     public function toValue()
    {
        return $this->_numer / $this->_denom;
    }
    
	
	public function __toString()
	{
		return $this->getNumer() . '/' . $this->getDenom();
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
	public function match(Sphere_Node_Rational_RationalInterface $rational)
	{
		return ( ($this->getNumer() * $rational->getDenom()) - ($this->getDenom * $rational->getNumer()) );
	}
	

}

//$rational = Sphere_Node_Rational::factory(48, 17);

//echo Sphere_Node_Rational::path($rational);
