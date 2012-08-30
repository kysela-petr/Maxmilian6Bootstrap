<?php

namespace FrontModule;

use Nette\Security as NS;

/**
 * SignPresenter
 * =====
 * Presenter pro přihlášení a odhlášení uživatelů
 * 
 * @author Kysela Petr <petr®kysela.biz>
 * @copyright Copyright (c) 2012, Kysela Petr
 * @category Presenter
 * @package Maxmilian\
 * @uses \BasePresenter
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version 6.0, 30.8.2012
 */
class SignPresenter extends BasePresenter
{


	/**
	 * Sign in form component factory.
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentSignInForm()
	{
		$form = new \Kysela\Forms\BootstrapForm;
		$form->addText('username', 'Username:')
			->setRequired('Please provide a username.');

		$form->addPassword('password', 'Password:')
			->setRequired('Please provide a password.');

		$form->addCheckbox('remember', 'Remember me on this computer');

		$form->addSubmit('send', 'Sign in');

		$form->onSuccess[] = $this->signInFormSubmitted;
		return $form;
	}



	public function signInFormSubmitted($form)
	{
		try {
			$values = $form->getValues();
			if ($values->remember) {
				$this->getUser()->setExpiration('+ 14 days', FALSE);
			} else {
				$this->getUser()->setExpiration('+ 20 minutes', TRUE);
			}
			$this->getUser()->login($values->username, $values->password);
			$this->redirect('Homepage:');

		} catch (NS\AuthenticationException $e) {
			$form->addError($e->getMessage());
		}
	}


    public function actionIn()
    {
        $this->title = 'sign IN | ' . $this->title;
    }

	public function actionOut()
	{
		$this->getUser()->logout();
		$this->flashMessage('You have been signed out.');
		$this->redirect('in');
	}

}
