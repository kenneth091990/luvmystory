<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;


use App\Entity\UserEntity;
use App\Form\UserForm;

use App\Service\EmailService;
use App\Service\AuthService;


/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index")
     */
    public function index(AuthService $authService){

        if(!$authService->isLoggedIn()) return $authService->redirectToLogin();

        return $this->render('User/index.html.twig', [
            'javascripts' => array('/assets/js/vendor/datatables/jquery.dataTables.min.js','/assets/js/user/index.js') 

        ]);
    }

     /**
    * @Route("/ajax_list", name="user_ajax_list")
    */
    public function ajax_listAction(Request $request, AuthService $authService) {

        $get = $request->query->all();
  
        $result = array(
            "draw" => intval($get['draw']),
            "recordsTotal" => 0,
            "recordsFiltered" => 0,
            "data" => array()
        );
  
        $result = $this->getDoctrine()->getManager()->getRepository(UserEntity::class)->ajax_list($get, $this->get('session')->get('userData'));
  
        return new JsonResponse($result);
    }

    /**
     * @Route(
     *      "/form/{action}/{id}",
     *      defaults = {
     *          "action":  "n",
     *          "id": 0
     *      },
     *      requirements = {
     *          "action": "n|u"
     *      },
     *      name = "user_form"
     * )
     */
    public function formAction($action, $id, Request $request, AuthService $authService, EmailService $emailService) {

        if(!$authService->isLoggedIn()) return $authService->redirectToLogin();
        if(!$authService->isUserHasAccesses(array('CMS User New', 'CMS User Update'))) return $authService->redirectToHome();

        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository(UserEntity::class)->find(base64_decode($id));
        if(!$user) {
            $user = new UserEntity();
        }

        $formOptions = array('action' => $action, 'userTypes' => $authService->getUserTypes());
        $form = $this->createForm(UserForm::class, $user, $formOptions);

        if($request->getMethod() === 'POST') {

            $user_form = $request->get($form->getName());
            $result = $this->processForm($user_form, $user, $form, $request, $authService, $emailService);

           
            if($result['success']) {
                if($result['redirect'] === 'index') {
                    return $this->redirect($this->generateUrl('user_index'), 302);
                } else if($result['redirect'] === 'form') {
                    return $this->redirect($this->generateUrl('user_form', array(
                        'action' => 'u',
                        'id' => base64_encode($result['id'])
                    )), 302);
                } else if($result['redirect'] === 'form with error') {
                    return $this->redirect($this->generateUrl('user_form', array(
                        'action' => 'u',
                        'id' => base64_encode($result['id'])
                    )), 302);
                }
            } else {
                $form->submit($user_form, false);
            }
        }

        $title = ($action === 'n' ? 'New' : 'Update') . ' User';

        return  $this->render('User/form.html.twig', array(
            'title' => $title,
            'page_title' => $title,
            'form' => $form->createView(),
            'action' => $action,
            'id' => $id 
        ));
    }

    private function processForm($user_form, $user, $form, Request $request, $authService,  $emailService) {

        $em = $this->getDoctrine()->getManager();
        $errors = $em->getRepository(UserEntity::class)->validate($user_form);

        
        if(!count($errors)) {

            switch($user_form['action']) {

                case 'n': // new

                    $form->handleRequest($request);
                    if ($form->isValid()) {

                        if(isset($user_form['password']['first'])){
                            $user->setPassword($authService->better_crypt(md5($user_form['password']['first']), 15));

                        }
                        $user->setType('Admin');
                        $user->setStatus('Active');
                        $em->persist($user);
                        $em->flush();

                        

                        $this->get('session')->getFlashBag()->set('success_messages', 'Record Successfully Saved.');
                        $result['redirect'] = 'index';

                        $msg = $this->renderView('Email/account_info.html.twig', ['user' => $user, 'password' => $user_form['password']['first']]);
                        $emailService->send($user->getEmail(), 'Account Information', $msg);

                    } else {

                        $this->get('session')->getFlashBag()->set('error_messages', 'Something went wrong. Please try again.');
                        $result['redirect'] = 'form with error';
                    }

                    break;

                case 'u': // update

                 
                    $form->handleRequest($request);
                 

                    if ($form->isValid()) {


                        if(isset($user_form['password']['first']) && !empty($user_form['password']['first'])){

                            $user->setPassword($authService->better_crypt(md5($user_form['password']['first']), 15));
    
    
                        } else {
                            $user->setPassword($user->getPassword());
    
                        }
                        $em->persist($user);

                        $em->flush();

                        $this->get('session')->getFlashBag()->set('success_messages', 'Record Successfully Updated.');
                        $result['redirect'] = 'company view';

                    } else {

                        $this->get('session')->getFlashBag()->set('error_messages', 'Something went wrong. Please try again.');
                        $result['redirect'] = 'form with error';
                    }


               

                    break;

                case 'd': // delete


                    $user->setIsDeleted(true);
                    $em->flush();

                    $this->get('session')->getFlashBag()->set('success_messages', 'Record Successfully Deleted.');
                    $result['redirect'] = 'company view';

                    break;
            }

            $result['success'] = true;

        } else {

            foreach($errors as $error) {
                $this->get('session')->getFlashBag()->add('error_messages', $error);
            }

            $result['success'] = false;
        }
        return $result;
    }

    /**
     * @Route("/autocomplete", name="user_autocomplete")
     */
    public function autocompleteAction(Request $request) {

        return new JsonResponse(array(
            'query' => 'users',
            'suggestions' => $this->getDoctrine()->getManager()->getRepository(UserEntity::class)->autocompleteSuggestions($request->query->all(), $this->get('session')->get('userData'))
        ));
    }



      
}
