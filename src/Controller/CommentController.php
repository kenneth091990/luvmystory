<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;


use App\Entity\CommentEntity;
use App\Entity\StoryEntity;

use App\Service\EmailService;
use App\Service\AuthService;


/**
 * @Route("/comment")
 */
class CommentController extends AbstractController
{

   
    /**
     * @Route("/ajax_form_process", name="comment_ajax_form_process")
     */
    public function ajaxFormProcess(Request $request, AuthService $authService): JsonResponse
    {
       
       $result = [ 'success' =>  true, 'msg' => ''];


       if($request->getMethod() == "POST"){
        
        $commentForm  = $request->request->get('comment');

        $em = $this->getDoctrine()->getManager();

        $story = $em->getRepository(StoryEntity::class)->find(base64_decode($commentForm['story_id']));

        if(!$story){
            $result['success'] = false;
            $result['msg'] = 'Invalid Request';
            
        } else {
            
            $comment = new CommentEntity();
            $comment->setStory($story);
            if($authService->isLoggedIn()){

                $comment->setUser($authService->getUser());
            } else {

                $comment->setGuestName($commentForm['name']);
                $comment->setEmail($commentForm['email']);
            }   

            $comment->setMessage($commentForm['message']);
            $em->persist($comment);
            $em->flush();
        }
        

     } else {

         $result['success'] = false;
         $result['msg'] = 'Ooops something went wrong please try again later.';
     }
    
       return new JsonResponse($result);
    }
}
