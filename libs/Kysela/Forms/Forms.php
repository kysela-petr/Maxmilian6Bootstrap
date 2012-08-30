<?php

namespace Kysela\Forms;

/**
 * Forms
 * =====
 * Formuláře postavené na TwitterBootstrapRendereru
 * 
 * @author Kysela Petr <petr®kysela.biz>
 * @copyright Copyright (c) 2012, Kysela Petr
 * @category 
 * @package 
 * @uses \Nette\Object
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version 0.0, 30.8.2012
 */
class BootstrapForm extends \Nette\Application\UI\Form
{
    
    /**
     * Nastavení defaultního rendereru Twitter Bootstrap
     * @param \Nette\ComponentModel\IContainer $parent
     * @param string $name
     */
    public function __construct(\Nette\ComponentModel\IContainer $parent = NULL, $name = NULL)
    {
        parent::__construct($parent, $name);
        $this->setRenderer( new \Kdyby\Extension\Forms\BootstrapRenderer\BootstrapRenderer() );
    }
    
    
}