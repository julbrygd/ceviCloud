<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace SCToolbox\Doctrine\Types;

use \Doctrine\DBAL\Types\Type;
/**
 * Description of Permission
 *
 * @author stephan
 */
class Permission extends Type{
    public function getName() {
        return "permission";
    }

    public function getSQLDeclaration(array $fieldDeclaration, \Doctrine\DBAL\Platforms\AbstractPlatform $platform) {
        return $platform->getVarcharTypeDeclarationSQL($fieldDeclaration);
    }
    public function convertToDatabaseValue($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform) {
        $value = strtolower($value);
        $ret = null;
        if($value=="deny")
            $ret="d";
        else if($value=="allow")
            $ret="a";
        return $ret;
    }

    public function convertToPHPValue($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform) {
        $ret = null;
        if($value=="d")
            $ret = "deny";
        else if($value=="a")
            $ret = "allow";
        return $ret;
    }

    public function getDefaultLength(\Doctrine\DBAL\Platforms\AbstractPlatform $platform) {
        return 1;
    }

}

?>
