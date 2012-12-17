<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SCToolbox\Doctrine;

/**
 * Description of ArrayAccessEntity
 *
 * @author stephan
 */
class ArrayAccessEntity implements \ArrayAccess {

    public function offsetExists($offset) {
        $offset = ucfirst($offset);
        $value = $this->{"get$offset"}();
        return $value !== null;
    }

    public function offsetSet($offset, $value) {
        $offset = ucfirst($offset);
        $this->{"set$offset"}($value);
    }

    public function offsetGet($offset) {
        $offset = ucfirst($offset);
        return $this->{"get$offset"}();
    }

    public function offsetUnset($offset) {
        $offset = ucfirst($offset);
        $this->{"set$offset"}(null);
    }

}

?>
