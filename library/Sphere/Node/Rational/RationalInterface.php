<?php
interface Sphere_Node_Rational_RationalInterface
{
    /**
     * Returns the path for this Rational
     * @return string
     */
    public function getPath();
    
    
    /**
     * Returns the value of numer/denom
     * @return integer
     */
    public function toValue();
}
