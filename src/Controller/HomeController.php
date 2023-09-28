<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Cookie;

use App\Entity\UserEntity;
use App\Form\RegistrationForm;
use App\Form\UpdatePasswordForm;

use App\Form\LoginForm;
use App\Service\EmailService;
use App\Service\AuthService;


/**
 * @Route("/")
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home_index")
     */
    public function index(){
        return $this->render('Home/index.html.twig');
    }

    /**
     * @Route("/stories", name="home_stories")
     */
    public function stories(){
        return $this->render('Home/stories.html.twig');
    }

    /**
     * @Route("why_tell_your_story", name="home_why_tell_your_story")
     */
    public function why_tell_your_story(){
        return $this->render('Home/why_tell_your_story.html.twig');
    }

    /**
     * @Route("about_us", name="home_about_us")
     */
    public function about_us(){
        return $this->render('Home/about_us.html.twig');
    }

        /**
     * @Route("interviewer", name="home_interviewer")
     */
    public function interviewer(){
        return $this->render('Home/interviewer.html.twig');
    }

     /**
     * @Route("faq", name="home_faq")
     */
    public function faq(){
        return $this->render('Home/faq.html.twig');
    }
    
    /**
     * @Route("login", name="home_login")
     */
    public function login(){
        return $this->render('Home/login.html.twig');
    }

     /**
     * @Route("contact_us", name="home_contact_us")
     */
    public function contact_us(){
        return $this->render('Home/contact_us.html.twig');
    }

     /**
     * @Route("terms_of_service", name="home_terms_of_service")
     */
    public function terms_of_service(){
        return $this->render('Home/terms_of_service.html.twig');
    }

     /**
     * @Route("privacy", name="home_privacy")
     */
    public function privacy(){
        return $this->render('Home/privacy.html.twig');
    }

     /**
     * @Route("help", name="home_help")
     */
    public function help(){
        return $this->render('Home/help.html.twig');
    }

     /**
     * @Route("friends", name="home_friends")
     */
    public function friends(){
        return $this->render('Home/friends.html.twig');
    }

    
     /**
     * @Route("family", name="home_family")
     */
    public function family(){
        return $this->render('Home/family.html.twig');
    }

     /**
     * @Route("career", name="home_career")
     */
    public function career(){
        return $this->render('Home/career.html.twig');
    }

     /**
     * @Route("business", name="home_business")
     */
    public function business(){
        return $this->render('Home/business.html.twig');
    }

    /**
     * @Route("the_steps", name="home_the_steps")
     */
    public function the_stepsAction(){
        return $this->render('Home/the_steps.html.twig');
    }

    /**
     * @Route("registration", name="home_registration")
     */
    public function registrationAction(Request $request, EmailService $emailSevice, AuthService $authService){

        if($authService->isLoggedIn()) return $this->redirect($this->generateUrl('dashboard_index'), 302);

        $formOptions = [];

        $user = new UserEntity();
        $form = $this->createForm(RegistrationForm::class, $user, $formOptions);

        if($request->getMethod() === 'POST') {

            $reg_form = $request->get($form->getName());

            $em = $this->getDoctrine()->getManager();

            $errors = $em->getRepository(UserEntity::class)->validate_registration($reg_form);
            
            if(!count($errors)){

                $form->handleRequest($request);
                if ($form->isValid()) {
                    
                    $user->setPassword($authService->better_crypt(md5($reg_form['password']['first']), 15));
                    $user->setType('Client');
                    $user->setStatus('For Confirmation');
                    $user->setToken($this->generateTokenForVerification(12));
                    $em->persist($user);
                    $em->flush();
                    
                    $msg = $this->renderView('Email/registration_confirmation.html.twig', ['user' => $user]);
                    $emailSevice->send($reg_form['email'], 'Registration confirmation to LuvMyStory', $msg);

                    return $this->redirect($this->generateUrl('home_registration_success'),302);
                } else {

                    $this->get('session')->getFlashBag()->set('error_messages', 'Something went wrong. Please try again.');
                }

            } else {
                

                $form->submit($reg_form, false);

                foreach($errors as $error) {
                    $this->get('session')->getFlashBag()->add('error_messages', $error);
                }
            }
        }

        return $this->render('Home/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/registration_verification/{token}", name="home_registration_verification")
     */
    public function registrationVerificationAction($token)
    {

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(UserEntity::class)->findOneBy(array(
            'token' => $token,
            'status' => 'For Confirmation'
        ));

        if(!$user){

            $this->get('session')->getFlashBag()->add('error_messages', 'Invalid or expired token.');
        } else {

            $user->setStatus('Active');
            $em->flush();
            $this->get('session')->getFlashBag()->add('success_messages', 'Your regisration is now complete you can now login');

        }

        return $this->redirect($this->generateUrl('home_login'), 302);

    }

     /**
     * @Route("/travel", name="home_travel")
     */
    public function travelAction(){
        return $this->render('Home/travel.html.twig');
    }

      /**
     * @Route("/welcome", name="home_welcome")
     */
    public function welcomeAction(){
        return $this->render('Home/welcome.html.twig');
    }

    /**
     * @Route("/me", name="home_me")
     */
    public function meAction(){
        return $this->render('Home/me.html.twig');
    }

      /**
     * @Route("/book_now", name="home_book_now")
     */
    public function book_nowAction(AuthService $authService){

        if(!$authService->isLoggedIn()) {

            $this->get('session')->getFlashBag()->set('error_messages', 'You need to sign in to book an interview');
            return $this->redirect($this->generateUrl('home_registration'), 302);
        }


        return $this->render('Home/book_now.html.twig');
    }

    
    /**
     * @Route("/login", name="home_login")
     */
    public function loginAction(Request $request, AuthService $authService){

        if($authService->isLoggedIn()) return $this->redirect($this->generateUrl('dashboard_index'), 302);

        $formOptions = [];

        $user = new UserEntity();
        $form = $this->createForm(LoginForm::class, $user, $formOptions);

        if($request->getMethod() === 'POST') {

            $em = $this->getDoctrine()->getManager();
            $reg_form = $request->get($form->getName());
            $em = $this->getDoctrine()->getManager();


            $user = $em->getRepository(UserEntity::class)->findOneBy([
                'email' => $reg_form['email'],
                'status' => 'Active'
            ]);

            if($user && ($user->getPassword() === crypt(md5($reg_form['password']), $user->getPassword()) || $user->getPassword() === $reg_form['password'])) {

                $form->handleRequest($request);
                if ($form->isValid()) {
                    
                    $session = $this->get('session');
                    $req_uri = $session->has('req_uri') ? $session->get('req_uri') : false;
                    $session->clear();


                    $userData = array(
                        'id' => $user->getId(),
                        'type' => $user->getType(),
                        'email' => $user->getEmail(),
                        'firstName' => $user->getFirstName(),
                        'middleName' => $user->getMiddleName(),
                        'lastName' => $user->getLastName(),
                        'fullName' => $user->getFullName(),
                        'profilePhoto' => $user->getFileWebPath()
                    );


                    $session->set('userData', $userData);

                    $url = $this->generateUrl('dashboard_book_now');

                    $response = new RedirectResponse($url);
                    
                    $response->headers->setCookie(new Cookie('userId', $user->getIdEncoded(), (time() + (86400))));
                    $response->headers->setCookie(new Cookie('username', $user->getEmail(), (time() + (86400))));
                
                    if(isset($login['remember'])) {
                        $response->headers->setCookie(new Cookie('remUser', $user->getEmail(), strtotime('+1 year')));
                        $response->headers->setCookie(new Cookie('remPwd', $user->getPassword(), strtotime('+1 year')));
                    } else {
                        $response->headers->setCookie(new Cookie('remUser', null, -1));
                        $response->headers->setCookie(new Cookie('remPwd', null, -1));
                    }

                    $response->send();

                } else {

                    $this->get('session')->getFlashBag()->set('error_messages', 'Something went wrong. Please try again.');
                }

                
            } else {

                $this->get('session')->getFlashBag()->set('error_messages', 'Invalid username or password.');
            }
        }


        return $this->render('Home/login.html.twig', [ 'form' => $form->createView()]);
    }

    /**
     * @Route("/registration_success", name="home_registration_success")
     */
    public function registrationSuccessAction(){
        return $this->render('Home/registration_success.html.twig');
    }

    /**
     * @Route("/the_luv1_conversation", name="home_the_luv1_conversation")
     */
    public function the_luv1_conversationAction(){
        return $this->render('Home/the_luv1_conversation.html.twig');
    }

    

    /**
     * @Route("forgot_password", name="home_forgot_password")
     */
    public function forgotPasswordAction(Request $request, EmailService $emailSevice,AuthService $authService){

        $token = null;
        if($authService->isLoggedIn()) return $this->redirect($this->generateUrl('dashboard_index'), 302);

        if($request->getMethod() === 'POST') {
        
            $data = $request->request->all();
            
            $em = $this->getDoctrine()->getManager();
            $client = $em->getRepository(UserEntity::class)->findOneBy(['isDeleted' => 0, 'email' => $data['email'], 'type' => 'Client']);

            if(!$client){
                $this->get('session')->getFlashBag()->set('error_messages', 'Invalid email address');

            } else {

                $token = $this->generateTokenForVerification();
                $client->setPasswordToken($token);
                $em->flush();

                $msg = $this->renderView('Email/forgot_password.html.twig', ['user' => $client]);
                $emailSevice->send($client->getEmail(), 'Forgot Password', $msg);

            }

        }

        return $this->render('Home/forgot_password.html.twig', ['token' => $token]);
    }

     /**
     * @Route("update_password/{token}", name="home_update_password")
     */
    public function updatePasswordAction(AuthService $authService,  Request $request, $token){

        if($authService->isLoggedIn()) return $this->redirect($this->generateUrl('dashboard_index'), 302);

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(UserEntity::class)->findOneBy(['passwordToken' => $token, 'type' => 'Client', 'isDeleted' => 0]);
        $form = $this->createForm(UpdatePasswordForm::class, $user, []);
       
        if(!$user){

            $this->get('session')->getFlashBag()->set('error_messages', 'Invalid or expired token');
            return $this->redirect($this->generateUrl('home_index'), 302);

        }

   
        if($request->getMethod() === 'POST') {

            $updatePasswordForm = $request->get($form->getName());

            $em = $this->getDoctrine()->getManager();

            $errors = $em->getRepository(UserEntity::class)->validateUpdatePassword($updatePasswordForm);
            
            if(!count($errors)){

                $form->handleRequest($request);
                if ($form->isValid()) {
                    

                    $user->setPassword($authService->better_crypt(md5($updatePasswordForm['password']['first']), 15));
                    $user->setPasswordToken('');
                    $em->flush();
                    $this->get('session')->getFlashBag()->set('success_messages', 'Your password has been change.');
                    return $this->redirect($this->generateUrl('home_login'),302);
                } else {

                    $this->get('session')->getFlashBag()->set('error_messages', 'Something went wrong. Please try again.');
                }

            } else {
                

                $form->submit($updatePasswordForm, false);

                foreach($errors as $error) {
                    $this->get('session')->getFlashBag()->add('error_messages', $error);
                }
            }
        }

        return $this->render('Home/update_password.html.twig', [
            'token' => $token,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/logout", name="home_logout")
     */
    public function logoutAction(AuthService $authService) {

   
        if(!$authService->isLoggedIn()) return $authService->redirectToLogin();

        $this->get('session')->clear();

        if(isSet($_COOKIE['userId'])) {
            unset($_COOKIE['userId']);
            setcookie('userId', null, -1, '/');
        }

        if(isSet($_COOKIE['username'])) {
            unset($_COOKIE['username']);
            setcookie('username', null, -1, '/');
        }

        return $authService->redirectToLogin();
    }

    private function generateTokenForVerification($length = 12) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        $em = $this->getDoctrine()->getManager();
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        $token = $em->getRepository(UserEntity::class)->findOneBy(array('token' => $randomString));
        if($token){
            $this->generateTokenForVerification();
        }

        return $randomString;
    }
}
