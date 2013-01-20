<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Aurélien
 * Date: 16/09/12
 * Time: 22:26
 * To change this template use File | Settings | File Templates.
 */

namespace Aml\Bundle\WebBundle\Controller;

//use Ic\Bundle\PslwebBundle\Form\ForgotPasswordType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\Security\Core\SecurityContext;

use Aml\Bundle\WebBundle\Entity\User;
/*
use Ic\Bundle\PslwebBundle\Form\UserType;
use Ic\Bundle\PslwebBundle\Form\UserHandler;
use Ic\Bundle\PslwebBundle\Entity\UsersCommunaute;
use Ic\Bundle\PslwebBundle\Entity\User;
use Ic\Bundle\PslwebBundle\Entity\Role;
use Ic\Bundle\PslwebBundle\Entity\Organisme;
use Ic\Bundle\PslwebBundle\Entity\Communaute;*/

use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class SecureController extends Controller
{
	protected function _generatePassword ($length = 8) 
	{
	
	    // start with a blank password
	    $password = "";
	
	    // define possible characters - any character in this string can be
	    // picked for use in the password, so if you want to put vowels back in
	    // or add special characters such as exclamation marks, this is where
	    // you should do it
	    $possible = "123467890abcdfghjkmnpqrtvwxyzABCDFGHJKLMNPQRTVWXYZ?!#&";
	
	    // we refer to the length of $possible a few times, so let's grab it now
	    $maxlength = strlen($possible);
	  
	    // check for length overflow and truncate if necessary
	    if ($length > $maxlength) {
	      $length = $maxlength;
	    }
		
	    // set up a counter for how many characters are in the password so far
	    $i = 0; 
	    
	    // add random characters to $password until $length is reached
	    while ($i < $length) { 
	
	      // pick a random character from the possible ones
	      $char = substr($possible, mt_rand(0, $maxlength-1), 1);
	        
	      // have we already used this character in $password?
	      if (!strstr($password, $char)) { 
	        // no, so it's OK to add it onto the end of whatever we've already got...
	        $password .= $char;
	        // ... and increase the counter by one
	        $i++;
	      }
	
	    }
	
	    // done!
	    return $password;
	
	 }
	 
	 protected function _generateToken( $user ){
	 	$token = ''; 	
	 	
	 	$token .= $user->getEmail() . '-' . $user->getDateCreation()->getTimestamp();
	 	$token = base64_encode($token);

	 	return $token;
	 }
	
	/**
	 * @Route("/connexion", name="connexion")
	 * @Template()
	 * @Method({ "GET", "POST" }) 
	 */
	public function loginAction(Request $request)
	{
		//on verifie si on est pas deja connecte
//		$securityContext = $this->get('security.context');
//		if($securityContext->isGranted('IS_AUTHENTICATED_FULLY'))
//		{
//			return $this->redirect($this->generateUrl('admin'));
//		}

		$em = $this->getDoctrine()->getEntityManager();
	
		

		$session = $request->getSession();
		//$session->set('id_communaute', $communaute->getId());

		$error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
		$session->remove(SecurityContext::AUTHENTICATION_ERROR);
		return array
		(
			'error' => $error,
			'last_username' => $session->get(SecurityContext::LAST_USERNAME)
		);
	}
	
	/**
	 * @Route("/deconnexion", name="deconnexion")
	 */
	public function logoutAction()
	{
	}
}