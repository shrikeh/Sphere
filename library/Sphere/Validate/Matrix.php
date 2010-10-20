<?php
/**
 * Class for representing validating Matrices
 * @category        Sphere
 * @package         Sphere_Node
 * @subpackage      Validate
 * @copyright       Copyright (c) 2009 Barney Hanlon (http://www.shrikeh.net)
 * @author          B Hanlon <Barney_Hanlon@shrikeh.net>
 * @version         Revision $LastChangedRevision$ by $LastChangedBy$ on $LastChangedDate$  
 * @access          public
 */
/** Zend_Validate_Abstract **/
require_once 'Zend/Validate/Abstract.php';
/**
 * Class for representing validating Matrices
 * @category        Sphere
 * @package         Sphere_Node
 * @subpackage      Validate
 * @copyright       Copyright (c) 2009 Barney Hanlon (http://www.shrikeh.net)
 * @author          B Hanlon <Barney_Hanlon@shrikeh.net>
 * @version         Revision $LastChangedRevision$ by $LastChangedBy$ on $LastChangedDate$  
 * @access          public
 */
class Sphere_Validate_Matrix extends Zend_Validate_Abstract
{
    /**
     * Constant used to define the Matrix passed is not an instance of
     * the appropriate Interface
     * @var string
     */
    const MATRIX_NOT_INSTANCE    = 'matrixNotInstance';
    const MATRIX_NO_LFT_RATIONAL = 'matrixNoLftRational';
    const MATRIX_NO_RGT_RATIONAL = 'matrixNoLftRational';
    
    public function __construct()
    {
        
    }
    
    public function isValid($matrix)
    {
        if (!$matrix instanceof Sphere_Matrix_MatrixInterface) {
            $this->_error(self::MATRIX_NOT_INSTANCE);
            return false;
        }
        
        if (!$matrix->getLftRational() instanceof Sphere_Node_Rational_RationalInterface) {
          $this->_error(self::MATRIX_NO_LFT_RATIONAL);
          return false;
        }
        if (!$matrix->getLftRational() instanceof Sphere_Node_Rational_RationalInterface) {
          $this->_error(self::MATRIX_NO_LFT_RATIONAL);
          return false;
        }
        if (!$matrix->getLRgtRational() instanceof Sphere_Node_Rational_RationalInterface) {
          $this->_error(self::MATRIX_NO_RGT_RATIONAL);
          return false;
        }        
        
        return true;
    }
}