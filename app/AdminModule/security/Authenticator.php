<?php

namespace AdminModule\Security;

use Nette\Object,
    Nette\Security as NS,
    Nette\DateTime;


class Authenticator extends Object implements NS\IAuthenticator
{
	/** @var type \Nette\Database\Connection */
	private $db;	
	
	public function __construct(\Nette\Database\Connection $db)
	{
		$this->db = $db;
	}
	
	
    public function authenticate(array $credentials)
    {
        $email = $credentials[self::USERNAME];
		$lang = $credentials[2];
        $row = $this->userTable->select('user.*, user_role.role AS role')->where('email', $email)->limit(1)->fetch(); 
		
		if (!$row) {
            throw new NS\AuthenticationException("Uživatel nebyl nalezen!", self::IDENTITY_NOT_FOUND);
        }
		
		if ($row['deleted'] == 'yes' or $row['active'] == 'no') {
            throw new NS\AuthenticationException("Uživatel nebyl nalezen!", self::IDENTITY_NOT_FOUND);
        }
		
		$now = new DateTime('NOW');
		$future = new DateTime($row['login_blocked']);
		if ($row['login_blocked'] !== NULL and ($future > $now)) {
			
			$msg = 'Uživatelský účet je zablokován, přihlášení bude možné';
			if($lang == 'en'){
				$msg = 'The user account is blocked, you can log in again after about';
			}
			throw new NS\AuthenticationException($msg . " " . gmstrftime('%Hh %Mm %Ss', $future->getTimestamp() - $now->getTimestamp()) . "!", self::IDENTITY_NOT_FOUND);
        }
		
        $password = \KyselaPetr\Tools::passwordHash( $credentials[self::PASSWORD], $row['hash'] . $email ); // výpočet hesla
			

		//dump(array($credentials[self::PASSWORD], $password, $row['password']));
		
        if ($row['password'] !== $password) {
			if($row['login_fail'] == '2'){
				$this->userTable->where('email', $email)->update(array('login_fail' => 0, 'login_blocked' => new \Nette\DateTime('+15 minutes')));
				throw new NS\AuthenticationException('Zadali jste tři nesprávná hesla, účet bude z bezpečnostních důvodů na 15 minut zablokován', self::FAILURE);
			}else{
				$this->userTable->where('email', $email)->update(array('login_fail' => $row['login_fail'] + 1)); // inkrementace špatných přihlášení
				throw new NS\AuthenticationException('Zadali jste nesprávné heslo!', self::INVALID_CREDENTIAL);
			}
        }

		$this->userTable->where('email', $email)->update(array('login_count' => $row['login_count'] + 1, 'login_fail' => 0, 'login_blocked' => NULL)); // inkrementace databaze
		
        $identity = new NS\Identity($row->id, $row->role);
        $identity->userID = $row->id;
		$identity->email = $email;
		$identity->role = $row->role;
		$identity->roleID = $row->user_role_id;
		$identity->name = $row->name;
		
        return $identity;
    }
}

