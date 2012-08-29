<?php

/**
 * BasePresenter
 * =====
 * Základní presenter pro celou aplikaci Maxmilian
 * 
 * @author Kysela Petr <petr®kysela.biz>
 * @copyright Copyright (c) 2012, Kysela Petr
 * @category Presenter
 * @package Maxmilian
 * @uses BasePresenter
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version 6.0, 28.8.2012
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{

	/** 
     * Jazyk aplikace
     * @var string
     * @persistent */
	public $lang = 'cs';
    
    /**
     * Název stránky
     * @var string 
     */
    public $title = 'Maxmilian 6';
	    
    protected function beforeRender()
    {
        parent::beforeRender();
        $this->template->lang = $this->lang; // <html lang="{$lang}">
        $this->template->title = $this->title; // <title>{$lang}</title>
    }
    
    /*
     * PŘEKLADY APLIKACE
     ************************************************************/
	
    /**
     * Překladač pro šablony
     * @param type $class
     * @return type
     */
	public function createTemplate($class = NULL)
	{
		$template = parent::createTemplate($class);

		// pokud není nastaven, použijeme defaultní z configu
		if (!isset($this->lang)) {
			$this->lang = $this->context->parameters["lang"];
		}

		$this->context->translator->setLang($this->lang); // nastavíme jazyk
		$template->setTranslator($this->context->translator);

		return $template;
	}
	
	
	public function flashMessage($message, $type = "info")
	{
		if ($this->context->hasService("translator")) {
			$message = $this->getContext()->translator->translate($message);
		}
		return parent::flashMessage($message, $type);
	}

}
