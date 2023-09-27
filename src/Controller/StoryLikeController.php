<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;


use App\Entity\StoryLikeEntity;
use App\Entity\StoryEntity;

use App\Service\EmailService;
use App\Service\AuthService;


/**
 * @Route("/story_like")
 */
class StoryLikeController extends AbstractController
{



   /**
    * @Route("/like", name="story_like_like")
    */
    public function likeAction(Request $request, AuthService $authService) {

        $result = ['success' => true, 'msg'];
  
        if($authService->isLoggedIn()) {
            $em = $this->getDoctrine()->getManager();
            $rd = $request->request->all();

            $story = $em->getRepository(StoryEntity::class)->find(base64_decode($rd['id']));

            if(!$story){

                $result['success'] = false;
                $result['msg'] = 'Invalid request';
            } else {


                $storyLike = $em->getRepository(StoryLikeEntity::class)->findOneBy(['story' => $story, 'user' => $authService->getUser()]);

                if(!$storyLike){

                    $storyLike = new StoryLikeEntity();
                    $storyLike->setUser($authService->getUser());
                    $storyLike->setStory($story);
                    $em->persist($storyLike);
                }

                $storyLike->setIsDeleted($storyLike->isIsDeleted() ? false : true );
                $em->flush();

                $result['likeCtr'] = $em->getRepository(StoryEntity::class)->getLikeCtr($rd['id']);

                

            }            
        }
  
        return new JsonResponse($result);
     }


}
