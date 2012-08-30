<?php

namespace FrontModule;

use Nette\Diagnostics\Debugger;

/**
 * BasePresenter
 * =====
 * Základní presenter pro veškeré presentery FrontModulu 
 * 
 * @author Kysela Petr <petr®kysela.biz>
 * @copyright Copyright (c) 2012, Kysela Petr
 * @category Presenter
 * @package Maxmilian\Front
 * @uses \BasePresenter
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version 6.0, 28.8.2012
 */
abstract class BasePresenter extends \BasePresenter
{

    /*
     * KOMPONENTY
     ************************************************************/
    
    /**
     * Komponenta vytvářející css styly pro Front Module
     * @return \WebLoader\Nette\CssLoader
     */
	protected function createComponentCssFront()
	{
		$files = new \WebLoader\FileCollection(WWW_DIR . '/ui');
		$files->addFiles(array(
			'/plugins/colorpicker/css/colorpicker.css',
			'/plugins/datepicker/css/datepicker.css',
		));

		$compiler = \WebLoader\Compiler::createCssCompiler($files, WEB_TEMP_DIR);

		$compiler->addFileFilter(new \Webloader\Filter\LessFilter());
		
		return new \WebLoader\Nette\CssLoader($compiler, $this->template->basePath . '/webtemp');
	}

	/**
     * Komponenta vytvářející java script pro Front Module
     * @return \WebLoader\Nette\JavaScriptLoader
     */
	public function createComponentJsFront()
	{
		$files = new \WebLoader\FileCollection(WWW_DIR . '/ui');
		$files->addFiles(array(
			'/js/jquery-1.8.0.js', 
			'/js/netteForms.js', 
			'/js/nette.ajax.js', 
			'/js/bootstrap.js', 
			'/js/extensions/diagnostics.dumps.ajax.js', 
			'/js/extensions/scrollTo.ajax.js', 
			'/js/extensions/spinner.ajax.js', 
			'/plugins/colorpicker/js/bootstrap-colorpicker.js', 
			'/plugins/datepicker/js/bootstrap-datepicker.js',
			'/js/site.js'));

		$compiler = \WebLoader\Compiler::createJsCompiler($files, WEB_TEMP_DIR);

		return new \WebLoader\Nette\JavaScriptLoader($compiler, $this->template->basePath . '/webtemp');
	}

    
    protected function afterRender()
{
        if (Debugger::isEnabled() && Debugger::$bar) {
                $panels = \Nette\Reflection\ClassType::from(Debugger::$bar)
                        ->getProperty('panels');
                $panels->setAccessible(TRUE);
                $panels = $panels->getValue(Debugger::$bar);
                $this->payload->netteDumps = $panels['Nette\Diagnostics\DefaultBarPanel-4']->data;
        }
}
    
}