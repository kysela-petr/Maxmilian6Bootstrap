<?php

namespace FrontModule;

/**
 * BasePresenter
 * =====
 * Základní presenter pro veškeré presentery FrontModulu 
 * 
 * @author Kysela Petr <petr®kysela.biz>
 * @copyright Copyright (c) 2012, Kysela Petr
 * @category MaxmilianPresenter
 * @package Front
 * @uses \BasePresenter
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version 1.0, 28.8.2012
 */
abstract class BasePresenter extends \BasePresenter
{

    /** @see Nette\Application\Presenter#startup() */
	protected function startup()
    {
		parent::startup();
	}
   
    
    /*
     * KOMPONENTY
     ************************************************************/
    
//        protected public function createComponent ___ ($name)
//        {
//
//        }
    

}