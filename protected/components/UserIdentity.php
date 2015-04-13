<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	public function authenticate()
	{
		//sprawdzaj tylko, czy zostały podane: login i hasło w HTTP BASIC AUTH
		//prawdziwym uwierzytelnianiem zajmuje się Apache i odpowiednia konfiguracja w .htaccess
		if (isset($_SERVER['PHP_AUTH_USER'])) {
			$this->errorCode=self::ERROR_NONE;
		} else {
			$this->errorCode=self::ERROR_UNKNOWN_IDENTITY;
		}
		
		return !$this->errorCode;
	}
}