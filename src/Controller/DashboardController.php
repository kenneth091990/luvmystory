<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;


use App\Entity\UserEntity;
use App\Entity\ScheduleEntity;
use App\Entity\StoryEntity;

use App\Form\RegistrationForm;
use App\Form\ProfileForm;
use App\Form\ScheduleForm;

use App\Service\EmailService;
use App\Service\AuthService;


/**
 * @Route("/dashboard")
 */
class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="dashboard_index")
     */
    public function index(AuthService $authService){

        if(!$authService->isLoggedIn()) return $authService->redirectToLogin();

        return $this->render('Dashboard/index.html.twig');
    }


      /**
     * @Route("/schedules", name="dashboard_schedules")
     */
    public function schedules(AuthService $authService){

        if(!$authService->isLoggedIn()) return $authService->redirectToLogin();
        
        return $this->render('Dashboard/schedules.html.twig', [
            'javascripts' => array('/assets/js/vendor/datatables/jquery.dataTables.min.js','/assets/js/dashboard/schedules.js') 
        ]);
    }



    /**
     * @Route("/me_and_my_story", name="dashboard_my_profile")
     */
    public function myProfile(AuthService $authService){

        if(!$authService->isLoggedIn()) return $authService->redirectToLogin();
        $user = $authService->getUser();

        return $this->render('Dashboard/my_profile.html.twig',[ 'user' => $user]);
    }

    /**
     * @Route("/update_profile", name="dashboard_update_profile")
     */
    public function updateProfile(AuthService $authService, Request $request){

        if(!$authService->isLoggedIn()) return $authService->redirectToLogin();

        $user = $authService->getUser();
        $formOptions = [];
        $form = $this->createForm(ProfileForm::class, $user, $formOptions);

        
        if($request->getMethod() === 'POST') {

            $profileForm = $request->get($form->getName());

            $em = $this->getDoctrine()->getManager();

            $errors = $em->getRepository(UserEntity::class)->validate_profile_form($profileForm);
            
            if(!count($errors)){

                $form->handleRequest($request);
                if ($form->isValid()) {

                    $em->flush();

                    if(isset($_FILES['profile_photo']) && !empty($_FILES['profile_photo']['tmp_name'])) {
                        $baseName = $user->getId() . '-' . time() . '.' . pathinfo($_FILES['profile_photo']['name'], PATHINFO_EXTENSION);
                        $uploadFile = $user->getUploadRootDir() . '/' . $baseName;
               
                        if(move_uploaded_file($_FILES['profile_photo']['tmp_name'], $uploadFile)) {
                           $user->removeFile();
                           $user->setProfilePhotoDesc($_FILES['profile_photo']['name']);
                           $user->setParsedProfilePhotoDesc($baseName);

                           $session = $this->get('session');
                           $userData = $this->get('session')->get('userData');
                           $userData['profilePhoto'] = $user->getFileWebPath();
    
                           $session->set('userData', $userData);
                        }
               
                        $em->flush();
                     }
                    
                    $this->get('session')->getFlashBag()->set('success_messages', 'Profile Successfully Updated.');
                } else {

                    $this->get('session')->getFlashBag()->set('error_messages', 'Something went wrong. Please try again.');
                }

            } else {
                

                $form->submit($profileForm, false);

                foreach($errors as $error) {
                    $this->get('session')->getFlashBag()->add('error_messages', $error);
                }
            }
        }

        return $this->render('Dashboard/update_profile.html.twig',[ 'form' => $form->createView(), 'user' => $user]);
    }

    /**
     * @Route("/transactions", name="dashboard_transactions")
     */
    public function transactions(AuthService $authService){

        if(!$authService->isLoggedIn()) return $authService->redirectToLogin();

        return $this->render('Dashboard/transactions.html.twig', [
            'javascripts' => array('/assets/js/vendor/datatables/jquery.dataTables.min.js','/assets/js/dashboard/transactions.js') 
        ]);
    }

    /**
     * @Route("/book_now", name="dashboard_book_now")
     */
    public function book_nowAction(AuthService $authService){

        if(!$authService->isLoggedIn()){
            return $this->redirect($this->generateUrl('home_registration'), 302);
        }

        return $this->render('Dashboard/book_now.html.twig');
    }  

}
