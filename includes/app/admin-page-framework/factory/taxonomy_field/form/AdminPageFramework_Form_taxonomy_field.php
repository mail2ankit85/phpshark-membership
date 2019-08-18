<?php 
/**
	Admin Page Framework v3.8.20 by Michael Uno 
	Generated by PHP Class Files Script Generator <https://github.com/michaeluno/PHP-Class-Files-Script-Generator>
	<http://en.michaeluno.jp/phpshark-plugin>
	Copyright (c) 2013-2019, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT> */
class PHPShark_AdminPageFramework_Form_taxonomy_field extends PHPShark_AdminPageFramework_Form {
    public $sStructureType = 'taxonomy_field';
    public function get() {
        $this->sCapability = $this->callback($this->aCallbacks['capability'], '');
        if (!$this->canUserView($this->sCapability)) {
            return '';
        }
        $this->_formatElementDefinitions($this->aSavedData);
        $_oFieldsets = new PHPShark_AdminPageFramework_Form_View___FieldsetRows($this->getElementAsArray($this->aFieldsets, '_default'), null, $this->aSavedData, $this->getFieldErrors(), $this->aFieldTypeDefinitions, $this->aCallbacks, $this->oMsg);
        return $_oFieldsets->get();
    }
    }
    