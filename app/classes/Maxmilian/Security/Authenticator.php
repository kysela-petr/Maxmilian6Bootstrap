<?php

namespace Maxmilian\Security;

use Nette\Security as NS;

/**
 * Ověření uživatele při přihlášení
 */
class Authenticator extends \Nette\Object implements NS\IAuthenticator
{
	/** @var type \Nette\Database\Connection */
	private $database;	
	
	public function __construct(\Nette\Database\Connection $db)
	{
		$this->database = $db;
	}
	
	
    /**
	 * Ověření uživatele
	 * @param  array
	 * @return Nette\Security\Identity
	 * @throws Nette\Security\AuthenticationException
	 */
	public function authenticate(array $credentials)
    {
		list($username, $password) = $credentials;
        $row = $this->database->table('max_user')->where('email', $username)->fetch();

		if (!$row) {
			throw new NS\AuthenticationException("User '$username' not found.", self::IDENTITY_NOT_FOUND);
		}

		if ($row->password !== $p = \Kysela\Tools::passwordHash($password, $username) ) {
			throw new NS\AuthenticationException("Invalid password.", self::INVALID_CREDENTIAL);
		}

		unset($row->password);
		return new NS\Identity($row->id, $row->role, $row->toArray());
	}
}

