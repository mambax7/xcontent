<?php

/*
Module: xContent

Version: 2.01

Description: Multilingual Content Module with tags and lists with search functions

Author: Written by Simon Roberts aka. Wishcraft (simon@chronolabs.coop)

Owner: Chronolabs

License: See /docs - GPL 2.0
*/

// defined('XOOPS_ROOT_PATH') || exit('Restricted access.');

xoops_load('XoopsFormElement');

require_once __DIR__ . '/functions.php';

class XoopsFormSelectPages extends XoopsFormElement
{
    /**
     * Options
     *
     * @var array
     * @access private
     */
    public $_options = [];

    /**
     * Allow multiple selections?
     *
     * @var bool
     * @access private
     */
    public $_multiple = false;

    /**
     * Number of rows. "1" makes a dropdown list.
     *
     * @var int
     * @access private
     */
    public $_size = 1;

    /**
     * Pre-selcted values
     *
     * @var array
     * @access private
     */
    public $_value = [];

    public function __construct($caption, $name, $value = null, $size = 1, $multiple = false, $ownid = 0)
    {
        $this->setCaption($caption);
        $this->setName($name);
        $this->_multiple = $multiple;
        $this->_size     = (int)$size;
        if (isset($value)) {
            $this->setValue($value);
        }
        $this->addOption(0, _XCONTENT_NONE);
        foreach ($this->getPages($ownid) as $id => $title) {
            $this->addOption($id, $title);
        }
    }

    public function getPages($ownid)
    {
        $xcontentHandler = xoops_getModuleHandler(_XCONTENT_CLASS_XCONTENT, _XCONTENT_DIRNAME);
        $xcontents       = $xcontentHandler->getObjects(new Criteria('parent_id', 0), true);
        $langs_array     = $this->TreeMenu([], $xcontents, -1, $ownid);

        return $langs_array;
    }

    public function TreeMenu($langs_array, $xcontents, $level, $ownid)
    {
        ++$level;
        $xcontentHandler = xoops_getModuleHandler(_XCONTENT_CLASS_XCONTENT, _XCONTENT_DIRNAME);
        foreach ($xcontents as $storyid => $xcontent) {
            if ($storyid != $ownid) {
                $langs_array[$storyid] = str_repeat('--', $level) . xcontent_getTitle($storyid);
                if ($xcontentsb = $xcontentHandler->getObjects(new Criteria('parent_id', $storyid), true)) {
                    $langs_array = $this->TreeMenu($langs_array, $xcontentsb, $level, $ownid);
                }
            }
        }
        $level--;

        return $langs_array;
    }

    /**
     * Are multiple selections allowed?
     *
     * @return bool
     */
    public function isMultiple()
    {
        return $this->_multiple;
    }

    /**
     * Get the size
     *
     * @return int
     */
    public function getSize()
    {
        return $this->_size;
    }

    /**
     * Get an array of pre-selected values
     *
     * @param  bool $encode To sanitizer the text?
     * @return array
     */
    public function getValue($encode = false)
    {
        if (!$encode) {
            return $this->_value;
        }
        $value = [];
        foreach ($this->_value as $val) {
            $value[] = $val ? htmlspecialchars($val, ENT_QUOTES) : $val;
        }

        return $value;
    }

    /**
     * Set pre-selected values
     *
     * @param  $value mixed
     */
    public function setValue($value)
    {
        if (is_array($value)) {
            foreach ($value as $v) {
                $this->_value[] = $v;
            }
        } elseif (isset($value)) {
            $this->_value[] = $value;
        }
    }

    /**
     * Add an option
     *
     * @param string $value "value" attribute
     * @param string $name  "name" attribute
     */
    public function addOption($value, $name = '')
    {
        if ('' != $name) {
            $this->_options[$value] = $name;
        } else {
            $this->_options[$value] = $value;
        }
    }

    /**
     * Add multiple options
     *
     * @param array $options Associative array of value->name pairs
     */
    public function addOptionArray($options)
    {
        if (is_array($options)) {
            foreach ($options as $k => $v) {
                $this->addOption($k, $v);
            }
        }
    }

    /**
     * Get an array with all the options
     *
     * Note: both name and value should be sanitized. However for backward compatibility, only value is sanitized for now.
     *
     * @param bool|int $encode To sanitizer the text? potential values: 0 - skip; 1 - only for value; 2 - for both value and name
     * @return array Associative array of value->name pairs
     */
    public function getOptions($encode = false)
    {
        if (!$encode) {
            return $this->_options;
        }
        $value = [];
        foreach ($this->_options as $val => $name) {
            $value[$encode ? htmlspecialchars($val, ENT_QUOTES) : $val] = ($encode > 1) ? htmlspecialchars($name, ENT_QUOTES) : $name;
        }

        return $value;
    }

    /**
     * Prepare HTML for output
     *
     * @return string HTML
     */
    public function render()
    {
        $ele_name    = $this->getName();
        $ele_title   = $this->getTitle();
        $ele_value   = $this->getValue();
        $ele_options = $this->getOptions();
        $ret         = '<select size="' . $this->getSize() . '"' . $this->getExtra();
        if (false !== $this->isMultiple()) {
            $ret .= ' name="' . $ele_name . '[]" id="' . $ele_name . '" title="' . $ele_title . '" multiple="multiple">';
        } else {
            $ret .= ' name="' . $ele_name . '" id="' . $ele_name . '" title="' . $ele_title . '">';
        }
        foreach ($ele_options as $value => $name) {
            $ret .= '<option value="' . htmlspecialchars($value, ENT_QUOTES) . '"';
            if (count($ele_value) > 0 && in_array($value, $ele_value)) {
                $ret .= ' selected';
            }
            $ret .= '>' . $name . '</option>';
        }
        $ret .= '</select>';

        return $ret;
    }

    /**
     * Render custom javascript validation code
     *
     * @seealso XoopsForm::renderValidationJS
     */
    public function renderValidationJS()
    {
        // render custom validation code if any
        if (!empty($this->customValidationCode)) {
            return implode("\n", $this->customValidationCode);
            // generate validation code if required
        } elseif ($this->isRequired()) {
            $eltname    = $this->getName();
            $eltcaption = $this->getCaption();
            $eltmsg     = empty($eltcaption) ? sprintf(_FORM_ENTER, $eltname) : sprintf(_FORM_ENTER, $eltcaption);
            $eltmsg     = str_replace('"', '\"', stripslashes($eltmsg));

            return "\nvar hasSelected = false; var selectBox = myform.{$eltname};"
                   . 'for (i = 0; i < selectBox.options.length; i++) { if (selectBox.options[i].selected === true) { hasSelected = true; break; } }'
                   . "if (!hasSelected) { window.alert(\"{$eltmsg}\"); selectBox.focus(); return false; }";
        }

        return '';
    }
}
