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
use App\Entity\NotificationEntity;

use App\Form\RegistrationForm;
use App\Form\ProfileForm;
use App\Form\ScheduleForm;

use App\Service\EmailService;
use App\Service\AuthService;


/**
 * @Route("/schedule")
 */
class ScheduleController extends AbstractController
{

     /**
     * @Route("/", name="schedule_index")
     */
    public function index(AuthService $authService){

        if(!$authService->isLoggedIn()) return $authService->redirectToLogin();
        
        return $this->render('Schedule/index.html.twig', [
            'javascripts' => array('/assets/js/vendor/datatables/jquery.dataTables.min.js','/assets/js/schedule/index.js') 
        ]);
    }
     
   /**
    * @Route("/ajax_list", name="schedule_ajax_list")
    */
    public function ajax_listAction(Request $request, AuthService $authService) {

        $get = $request->query->all();
  
        $result = array(
            "draw" => intval($get['draw']),
            "recordsTotal" => 0,
            "recordsFiltered" => 0,
            "data" => array()
        );
  
        if($authService->isLoggedIn()) {
            $result = $this->getDoctrine()->getManager()->getRepository(ScheduleEntity::class)->ajax_list($get, $this->get('session')->get('userData'));
        }
  
        return new JsonResponse($result);
     }

    /**
     * @Route("/details/{id}", name="schedule_details")
     */
    public function schedule_detailsAction(AuthService $authService, $id, Request $request){

        if(!$authService->isLoggedIn()) return $authService->redirectToLogin();
        
        $em = $this->getDoctrine()->getManager();

        $schedule = $em->getRepository(ScheduleEntity::class)->find(base64_decode($id));

        if(!$schedule){
            $this->get('session')->getFlashBag()->add('error_messages', 'Schedule Not Found');
            return $this->redirect($this->generateUrl('dashboard_book_now'), 302);

        }

        $formOptions = [];
        $form = $this->createForm(ScheduleForm::class, $schedule, $formOptions);

        
        if($request->getMethod() === 'POST') {

            $scheduleForm = $request->get($form->getName());

            $em = $this->getDoctrine()->getManager();

            $errors = [];
            
            if(!count($errors)){

                $form->handleRequest($request);
                if ($form->isValid()) {

                    $em->flush();

                    if(isset($_FILES['file']) && !empty($_FILES['file']['tmp_name'])) {
                        $baseName = $schedule->getId() . '-' . time() . '.' . pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                        $uploadFile = $schedule->getUploadRootDir() . '/' . $baseName;
               
                        if(move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
                           $schedule->removeFile();
                           $schedule->setFileDesc($_FILES['file']['name']);
                           $schedule->setParsedFileDesc($baseName);

                        }
               
                        $em->flush();

                        $story = $em->getRepository(StoryEntity::class)->findOneBy(['schedule' => $schedule]);

                        if(!$story){
                            $story =  new StoryEntity();
                            $story->setTitle($schedule->getScheduleType());
                            $story->setSchedule($schedule);
                            $story->setIsRead(false);
                            $em->persist($story);
                            $em->flush();

                            $notification =  new NotificationEntity();
                            $notification->setNotificationType('Story');
                            $notification->setUser($schedule->getUser());
                            $notification->setStory($story);
                            $notification->setIsRead(false);
                            $em->persist($notification);
                            $em->flush();
                        }
                     }
                    
                    $this->get('session')->getFlashBag()->set('success_messages', 'Schedule Successfully Updated.');
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
        return $this->render('Schedule/details.html.twig', [
            'schedule' => $schedule,
            'id' => $id,
            'form' => $form->createView(),
            'javascripts' => array('') 
        ]);
    }
}
