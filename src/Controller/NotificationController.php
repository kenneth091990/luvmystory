<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;


use App\Entity\NotificationEntity;
use App\Form\NotificationForm;

use App\Service\EmailService;
use App\Service\AuthService;


/**
 * @Route("/notification")
 */
class NotificationController extends AbstractController
{



   /**
    * @Route("/list", name="notification_list")
    */
    public function listAction(Request $request, AuthService $authService) {

        $result = ['success' => true, 'msg'];
  
        if($authService->isLoggedIn()) {
            $em = $this->getDoctrine()->getManager();
            $result['unreadNoticationCtr'] = count($em->getRepository(NotificationEntity::class)->findBy(['user' => $authService->getUser(), 'isRead' => false], ['id' => 'ASC']));
            $result['html'] = $this->renderView('Notification/list.html.twig', [
                'notifications' => $em->getRepository(NotificationEntity::class)->findBy(['user' => $authService->getUser()], ['id' => 'DESC'], 5),
                'unreadNotifications' => $result['unreadNoticationCtr']
            ]);
        }
  
        return new JsonResponse($result);
     }


}
