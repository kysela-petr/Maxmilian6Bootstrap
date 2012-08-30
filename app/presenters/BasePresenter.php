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
     * @var string | jazyk aplikace, tag html
     * @persistent */
	public $lang = 'cs';
    
    /** @var string | název stránky, tag title */
    public $title = 'Maxmilian 6';
	    
    /** @var string | popis stránky, tag meta description */
    public $description = '';
    
    
    /** @see \Nette\Application\UI\Presenter::beforeRender() */
    protected function beforeRender()
    {
        parent::beforeRender();
        $this->template->lang = $this->lang;
        $this->template->title = $this->title;
        $this->template->description = $this->description;
        
        // zAJAXování aplikace
        if ($this->isAjax())
        {
            $this->invalidateControl();
        }
        
    }
    
    
    /*
     * PŘEKLADY APLIKACE
     ************************************************************/
	
    /**
     * Překladač pro šablony
     * @param string|NULL $class
     * @return Nette\Templating\FileTemplate
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
	
	/**
     * Překladač pro FlashMessage
     * @param string $message
     * @param string $type
     * @return \stdClass
     */
	public function flashMessage($message, $type = "info")
	{
		if ($this->context->hasService("translator")) {
			$message = $this->getContext()->translator->translate($message);
		}
		return parent::flashMessage($message, $type);
	}

}
