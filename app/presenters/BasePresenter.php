<?php

/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{

	/** @persistent */
	public $lang = 'cs';
	
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
