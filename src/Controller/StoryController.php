<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;


use App\Entity\StoryEntity;
use App\Form\StoryForm;
use App\Entity\ShareStoryEntity;
use App\Entity\UserEntity;
use App\Entity\NotificationEntity;


use App\Service\EmailService;
use App\Service\AuthService;


/**
 * @Route("/story")
 */
class StoryController extends AbstractController
{

    /**
     * @Route("/", name="story_index")
     */
    public function story(AuthService $authService){

        if(!$authService->isLoggedIn()) return $authService->redirectToLogin();
        
        return $this->render('Story/index.html.twig', [
            'javascripts' => array('/assets/js/vendor/datatables/jquery.dataTables.min.js','/assets/js/story/index.js') 
        ]);
    }

     /**
     * @Route("/arhive", name="story_archive")
     */
    public function archive(AuthService $authService){

        if(!$authService->isLoggedIn()) return $authService->redirectToLogin();
        
        return $this->render('Story/archive.html.twig', [
        ]);
    }

     /**
     * @Route("/share", name="story_share")
     */
    public function storyShare(AuthService $authService){

        if(!$authService->isLoggedIn()) return $authService->redirectToLogin();
        
        return $this->render('Story/share.html.twig', [
            'javascripts' => array('/assets/js/vendor/datatables/jquery.dataTables.min.js','/assets/js/story/share.js') 
        ]);
    }

   /**
    * @Route("/ajax_list", name="story_ajax_list")
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
            $result = $this->getDoctrine()->getManager()->getRepository(StoryEntity::class)->ajax_list($get, $this->get('session')->get('userData'));
        }
  
        return new JsonResponse($result);
     }

      /**
    * @Route("/share_ajax_list", name="story_share_ajax_list")
    */
    public function share_ajax_listAction(Request $request, AuthService $authService) {

        $get = $request->query->all();
  
        $result = array(
            "draw" => intval($get['draw']),
            "recordsTotal" => 0,
            "recordsFiltered" => 0,
            "data" => array()
        );
  
        if($authService->isLoggedIn()) {
            $result = $this->getDoctrine()->getManager()->getRepository(ShareStoryEntity::class)->ajax_list($get, $this->get('session')->get('userData'));
        }
  
        return new JsonResponse($result);
     }

    /**
     * @Route("/details/{id}", name="story_details")
     */
    public function story_detailsAction(AuthService $authService, $id, Request $request){

        if(!$authService->isLoggedIn()) return $authService->redirectToLogin();
        
        $em = $this->getDoctrine()->getManager();

        $story = $em->getRepository(StoryEntity::class)->find(base64_decode($id));

        if(!$story){
            $this->get('session')->getFlashBag()->add('error_messages', 'Story Not Found');
            return $this->redirect($this->generateUrl('dashboard_book_now'), 302);

        }

        $notification = $em->getRepository(NotificationEntity::class)->findOneBy(['user' => $authService->getUser(), 'story' => $story]); 
        //s$story->getNotification();
        if($notification){
            if(!$notification->isIsRead()){
                $notification->setIsRead(true);
                $em->flush();
            }
    
        }
      
        $formOptions = [];
        $form = $this->createForm(StoryForm::class, $story, $formOptions);

        
        if($request->getMethod() === 'POST') {

            $storyForm = $request->get($form->getName());
            $pr = $request->request->all();

            $em = $this->getDoctrine()->getManager();

            $errors = [];
            if(!count($errors)){

                $form->handleRequest($request);
                if ($form->isValid()) {

                    $story->setIsPublic(isset($pr['is_public']) ? true : false);
                    $em->flush();

                    if(isset($_FILES['story_photo']) && !empty($_FILES['story_photo']['tmp_name'])) {
                        $baseName = $story->getId() . '-' . time() . '.' . pathinfo($_FILES['story_photo']['name'], PATHINFO_EXTENSION);
                        $uploadFile = $story->getUploadRootDir() . '/' . $baseName;
               
                        if(move_uploaded_file($_FILES['story_photo']['tmp_name'], $uploadFile)) {
                           $story->removeFile();
                           $story->setFileDesc($_FILES['story_photo']['name']);
                           $story->setParsedFileDesc($baseName);

                        }
               
                        $em->flush();
                     }
                    
                    $this->get('session')->getFlashBag()->set('success_messages', 'Story Successfully Updated.');
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
        return $this->render('Story/details.html.twig', [
            'story' => $story,
            'id' => $id,
            'form' => $form->createView(),
            'javascripts' => array('/assets/js/story/details.js') 
        ]);
    }

        /**
     * @Route("/telling/{id}", name="story_telling")
     */
    public function tellingAction(AuthService $authService, $id, Request $request){
      
        if(!$authService->isLoggedIn()) return $authService->redirectToLogin();

        $em = $this->getDoctrine()->getManager();
        $story = $em->getRepository(StoryEntity::class)->findOneBy(['id' => base64_decode($id)]);
        $sharedStory = $em->getRepository(ShareStoryEntity::class)->findOneBy(['user' => $authService->getUser(), 'story' => $story]);
        $notification = $em->getRepository(NotificationEntity::class)->findOneBy(['user' => $authService->getUser(), 'story' => $story]); 
        $likeCtr = $em->getRepository(StoryEntity::class)->getLikeCtr($id);
        $commentCtr = $em->getRepository(StoryEntity::class)->getCommentCtr($id);
        
        if(!$story){
            $this->get('session')->getFlashBag()->add('error_messages', 'Story Not Found');
            return $this->redirect($this->generateUrl('home_index'), 302);

        } else {

            if(!$story->isIsPublic() && !in_array($authService->getUser()->getId(), $story->sharedStoriesIds())){
               
                $this->get('session')->getFlashBag()->add('error_messages', 'Story Not Found');
                return $this->redirect($this->generateUrl('home_index'), 302);
            }
        }

        if($notification && !$notification->isIsRead()){
            $notification->setIsRead(true);
            $em->flush();
            
        }

        return $this->render('Story/telling.html.twig', [
            'likeCtr' => $likeCtr,
            'commentCtr' => $commentCtr,
            'story' => $story,
            'javascripts' => array('/assets/js/story/telling.js') 

        ]);
    }

          /**
     * @Route("/preview/{id}", name="story_preview")
     */
    public function previewAction(AuthService $authService, $id, Request $request){

       
        $result= ['success' => true, 'msg' => '']; 
  
        if($authService->isLoggedIn()) {
            
            $em = $this->getDoctrine()->getManager();
            $story = $em->getRepository(StoryEntity::class)->find( base64_decode($id));
    
            if(!$story){
              
                $result['succss']  = false;
                $result['msg'] = 'Story not found';
            } else {

                $result['html'] = '<iframe src="'. $this->generateUrl('story_telling', ['id' => $id]) .'"  height="500" width="100%" style="border:0">';
            }
    
        }
  
        return new JsonResponse($result);
    }

    /**
     * @Route("/ajax_delete", name="story_ajax_delete")
     */
    public function ajaxDeleteAction(AuthService $authService, Request $request){

       
        $result= ['success' => true, 'msg' => '']; 
  
        if($authService->isLoggedIn()) {

            $pr = $request->request->all();
            
            $em = $this->getDoctrine()->getManager();
            $story = $em->getRepository(StoryEntity::class)->find( base64_decode($pr['id']));
    
            if(!$story){
              
                $result['succss']  = false;
                $result['msg'] = 'Story not found';
            } else {

                $story->setIsDeleted(true);
                $em->flush();
                $result['msg'] = 'Your story is successfully deleted';
                
            }
    
        }
  
        return new JsonResponse($result);
    }

    

    /**
     * @Route("/ajax_share_form", name="story_ajax_share_form")
     */
    public function ajax_share_formAction(AuthService $authService, Request $request){

       
        $result= ['success' => true, 'msg' => '']; 
  
        if($authService->isLoggedIn()) {

            $id = $request->query->get('id');

            $result['html'] = $this->renderView('Story/ajax_share_form.html.twig', ['id' => $id]);
        }
  
        return new JsonResponse($result);
    }

       /**
     * @Route("/ajax_share_form_action", name="story_ajax_share_form_action")
     */
    public function story_ajax_share_form_actionAction(AuthService $authService, Request $request, EmailService $emailService){

       
        $result= ['success' => true, 'msg' => '']; 
  
        if($authService->isLoggedIn()) {

            $fd = $request->request->get('shareForm');
            $email = $fd['email'];

            $em = $this->getDoctrine()->getManager();
            $story = $em->getReference(StoryEntity::class, base64_decode($fd['id']));

            
          //  $user = $em->getReference(UserEntity::class, $fd['user']);
            $user = $em->getRepository(UserEntity::class)->findOneBy(['email' => $email, 'isDeleted' => 0]);  
           
            if(!$user){
           
                $msg = $this->renderView('Email/share_story.html.twig', ['email' => $email, 'story' => $story]);
                $emailService->send($email, 'An Unforgettable Story You Have To Hear!', $msg);
                $result['msg'] = 'Story has been shared.';
            } else {
                
                $sharedStory = $em->getRepository(ShareStoryEntity::class)->findOneBy(['isDeleted' => 0, 'user' => $user , 'story' => $story]);
                if($sharedStory){

                    $result['success'] = false;
                    $result['msg'] = 'Story already shared to this person';
                } else {

                    $shareStory = new ShareStoryEntity();
                    $shareStory->setUser($user);
                    $shareStory->setStory($story);
                    $em->persist($shareStory);
                    $em->flush();

                    $notification =  new NotificationEntity();
                    $notification->setNotificationType('Share');
                    $notification->setUser($user);
                    $notification->setStory($shareStory->getStory());
                    $notification->setIsRead(false);
                    $em->persist($notification);
                    $em->flush();

                    $result['msg'] = 'Story has been shared.';
                    $result['html'] = $this->renderView('Story/share_box.html.twig', [ 'shareStory' => $shareStory]);

                }
            }
          
        }
  
        return new JsonResponse($result);
    }
    

       /**
    * @Route("/comments/ajax_list", name="story_comments_ajax_list")
    */
    public function comments_jax_listAction(Request $request, AuthService $authService) {

        $post = $request->request->all();


        $result = ['success' => true, 'msg' => ''];
        $em = $this->getDoctrine()->getManager();
        $story = $em->getRepository(StoryEntity::class)->find(base64_decode($post['id']));

        if(!$story){

            $result['success'] = false;
            $result['msg'] = 'Ooops something went wrong please contact system administrator.';
 
        } else {

            $comments  = $this->getDoctrine()->getManager()->getRepository(StoryEntity::class)->comment_ajax_list($story->getId(), $this->get('session')->get('userData'));
            $result['html'] = $this->renderView('Story/comments.html.twig', ['comments' => $comments]);
            
         }

  
        return new JsonResponse($result);
     }

     
    /**
     * @Route("/ajax_remove_share_story", name="story_ajax_remove_share_story")
     */
    public function ajax_remove_share_storyAction(AuthService $authService, Request $request){

       
        $result= ['success' => true, 'msg' => '']; 
  
        if($authService->isLoggedIn()) {

            $id = $request->request->get('id');

            $em = $this->getDoctrine()->getManager();

            $sharedStory  = $em->getRepository(ShareStoryEntity::class)->find(base64_decode($id));

            if(!$sharedStory){
                
                $result['success'] = false;
                $result['msg'] = 'Ooops something went wrong please contact System Administrator';
            } else {    
                $result['id'] = $sharedStory->getId();
                $sharedStory->setIsDeleted(true);
                $em->flush();
                $result['msg'] = 'Story successfully remove to your list of shared story.';
            }
        }
  
        return new JsonResponse($result);
    }


}
