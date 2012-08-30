<?php

namespace FrontModule;

/**
 * HomepagePresenter
 * =====
 * Presenter úvodní stránky FrontModulu
 * 
 * @author Kysela Petr <petr®kysela.biz>
 * @copyright Copyright (c) 2012, Kysela Petr
 * @category Presenter
 * @package Maxmilian\Front
 * @uses \Front\BasePresenter
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version 6.0, 28.8.2012
 */
class HomepagePresenter extends BasePresenter
{
    /** @see Nette\Application\Presenter#startup() */
	protected function startup()
    {
		parent::startup();
	}

	public function actionDefault()
    {
        $this->title = 'default | ' . $this->title;
	}

	public function actionHome()
    {
        $this->title = 'home | ' . $this->title;
	}
    
    
    /*
     * SIGNÁLY
     ************************************************************/
    
//        protected public function handle ___ ()
//        {
//        
//        }
    
    
    /*
     * KOMPONENTY
     ************************************************************/
    
//        protected public function createComponent ___ ($name)
//        {
//
//        }
    
}
