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
	
	
	public function createComponentCss()
	{
		$files = new \WebLoader\FileCollection(WWW_DIR . '/ui');
		$files->addFiles(Nette\Utils\Finder::findFiles('*.less')->from('/less'));
		$files->addFiles(array(
			'/plugins/colorpicker/less/colorpicker.less',
			'/plugins/datepicker/less/datepicker.less',
		));

		$compiler = \WebLoader\Compiler::createCssCompiler($files, WEB_TEMP_DIR);

		return new \WebLoader\Nette\CssLoader($compiler, $this->template->basePath . '/webtemp');
	}

	
	public function createComponentJs()
	{
		$files = new \WebLoader\FileCollection(WWW_DIR . '/ui');
		$files->addFiles(array(
			'/js/jquery-1.8.0.js', 
			'/js/netteForms.js', 
			'/js/nette.ajax.js', 
			'/js/bootstrap.js', 
			'/js/less-1.3.0.min.js', 
			'/js/extensions/diagnostics.dumps.ajax.js', 
			'/js/extensions/scrollTo.ajax.js', 
			'/js/extensions/spinner.ajax.js', 
			'/plugins/colorpicker/js/bootstrap-colorpicker.js', 
			'/plugins/datepicker/js/bootstrap-datepicker.js',
			'/js/site.js'));

		$compiler = \WebLoader\Compiler::createJsCompiler($files, WEB_TEMP_DIR);

		return new \WebLoader\Nette\JavaScriptLoader($compiler, $this->template->basePath . '/webtemp');
	}
	
}
