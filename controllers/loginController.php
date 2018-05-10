<?php
class loginController extends controller {

	/** 
	* Call login view
	* @return send to home view if success login
	*/

	public function index()
	{
		$data = array();

		if (isset($_POST['email']) && !empty($_POST['email'])) 
		{
			$email = addslashes($_POST['email']);
			$pass  = addslashes($_POST['password']);

			$user = new Users();

			if($user->doLogin($email, $pass))
			{
				header("Location: ".BASE);
			} else{
				$data['error'] = 'E-mail e/ou senha errados.';
			}
		}

		$this->loadView('login', $data);
	}

	/** 
	* Logout the running user
	* @return login view
	*/

	public function logout()
	{
		$user = new Users();
		$user->logout();
		header("Location: ".BASE);
	}


}