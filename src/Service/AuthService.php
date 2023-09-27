<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Entity\UserEntity;

Class AuthService {

    private $em;
    private $container;

    public function __construct(EntityManagerInterface $em, ContainerInterface $container) {

        $this->em = $em;
        $this->container = $container;
    }

    // Original PHP code by Chirp Internet: www.chirp.com.au
    public function better_crypt($input, $rounds = 7)
    {
        $salt = "";
        $salt_chars = array_merge(range('A','Z'), range('a','z'), range(0,9));
        for($i=0; $i < 22; $i++) {
            $salt .= $salt_chars[array_rand($salt_chars)];
        }
        return crypt($input, sprintf('$2a$%02d$', $rounds) . $salt);
    }

    /**
     * Checks if the user is logged in or not
     */
    public function isLoggedIn($requestUri = true) {

        $session = $this->container->get('session');

        if($session->has('userData')) {
            return true;
        } else {
            if($requestUri) {
                $req_uri = $_SERVER['REQUEST_URI'];
                if($req_uri !== $this->container->get('router')->generate('home_login'));
            }
            return false;
        }
    }

    /**
     * Checks if the user has the ess
     */
    public function isUserHasAccesses($accessDescriptions, $hasErrorMsg=true, $matchCtr=false) {
        $session = $this->container->get('session');
        //$session->save(); // This will automatically call session_write_close() to prevent session lock timeout error
        $userData = $session->get('userData');
        if($userData['type'] === 'Super Admin') {
            return true;
        } else {
            if($matchCtr) {
                $accessCtr = 0;
                foreach($accessDescriptions as $accessDescription) if(in_array($accessDescription, $userData['accesses'])) $accessCtr++;
                $hasAccess = count($accessDescriptions) === $accessCtr;
                if(!$hasAccess) {
                    if($hasErrorMsg) {
                        $session->getFlashBag()->set('error_messages', "You don't have the right to access the page. Please contact the administrator.");
                    }
                    return false;
                } else {
                    return true;
                }
            } else {
                foreach($accessDescriptions as $accessDescription) if(in_array($accessDescription, $userData['accesses'])) return true;
                if($hasErrorMsg) $session->getFlashBag()->set('error_messages', "You don't have the right to access the page. Please contact the administrator.");
                return false;
            }
        }
    }

    /**
     * Redirects to login page
     */
    public function redirectToLogin() {

        return new RedirectResponse($this->container->get('router')->generate('home_login'), 302);
    }


    /**
     * Redirects to home page
     */
    public function redirectToHome() {

        return new RedirectResponse($this->container->get('router')->generate('admin'), 302);
    }

    /**
     * Get user
     */
    public function getUser() {

        $userData = $this->container->get('session')->get('userData');
        return $this->em->getRepository(UserEntity::class)->find($userData['id']);
    }

    /**
     * Get user types
     */
    public function getUserTypes() {

        return array(
            'Admin'
        );
    }

    public function getAccesses() {

        return array();
    }

    /**
     * Checks if the user is logged in or not
     */
    public function accountIsLoggedIn($requestUri = true) {

        $session = $this->container->get('session');

        if($session->has('accountUserData')) {
            return true;
        } else {
            if($requestUri) {
                $req_uri = $_SERVER['REQUEST_URI'];
                if($req_uri !== $this->container->get('router')->generate('auth_login') &&
                    $req_uri !== $this->container->get('router')->generate('auth_logout') &&
                    $req_uri !== $this->container->get('router')->generate('auth_forgot_password') &&
                    //$req_uri !== $this->container->get('router')->generate('auth_forgot_password_confirmation') &&
                    strpos($req_uri, 'ajax') === false) $session->set('req_uri', $req_uri);
            }
            return false;
        }
    }

    /**
     * Redirects to login page of user
     */
    public function account_redirectToLogin() {

        return new RedirectResponse($this->container->get('router')->generate('admin'), 302);
    }
}