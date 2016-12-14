<?php

namespace controller;

use \W\Controller\Controller;
use \W\Security\AuthentificationModel;
use \W\Model\UsersModel;

class LoginController extends Controller {

	public function form() {
		//var_dump('hello xdebug !');
		
		$errors = array(); // <- Je crée ici un tableau d'erreurs
		//var_dump('Contenu de $_POST : ', $_POST);


		if($_POST){
			if(empty($_POST['pseudo'])){
				$errors['pseudo'] = 'Vous devez renseigner un pseudo !';
			}

			if(empty($_POST['mot_de_passe'])){
				$errors['mot_de_passe'] = 'Vous devez renseigner un mot de passe !';
			}
			//var_dump('Contenu de mes erreurs après vérification empty()', $errors);

			$auth = new AuthentificationModel();

			/* je fais appel au modèle d'authentification de façon à profiter de la méthode "isValidLoginInfo"
			qui va vérifier que la combinaison "pseudo/mot de passe" entré par l'utilisateur
			correspond bien à un utilisateur en BDD */
			
			$pseudo = ! empty($_POST['pseudo']) ? $_POST['pseudo'] : '';
			$motDePasse = ! empty($_POST['mot_de_passe']) ? $_POST['mot_de_passe'] : '';
			
			//var_dump('Pseudo : ', $pseudo);
			//var_dump('Mot de passe : ', $motDePasse);

			$userId = $auth->isValidLoginInfo($_POST['pseudo'], $_POST['mot_de_passe']);

			/*var_dump('user id : ', $userId);*/

			if($userId === 0){
				$errors['pseudo/mot_de_passe'] = 'les informations de connection entrées sont incorrectes !';
			}

			//var_dump('Contenu de mes erreurs après validation totale : ', $errors);

			/* Je vérifie que le tableau d'erreur est vide, ce qui signifie que le formulaire a bien été rempli */
			if(empty($errors)){
				$usersModel = new UsersModel();
				$userInfos = $usersModel->find($userId);
				//var_dump('Informations de l\'utilisateur', $userInfos);
				$auth->LogUserIn($userInfos);

				$this->redirectToRoute('default_home');
			}
		}
		$this->show('login/form', array('errors'=>$errors));
	}
}

?>