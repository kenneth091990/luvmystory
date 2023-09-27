<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;


use App\Entity\SchedulePaymentEntity;
use App\Service\AuthService;


/**
 * @Route("/schedule_payment")
 */
class SchedulePaymentController extends AbstractController
{
     
   /**
    * @Route("/ajax_list", name="schedule_payment_ajax_list")
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
            $result = $this->getDoctrine()->getManager()->getRepository(SchedulePaymentEntity::class)->ajax_list($get, $this->get('session')->get('userData'));
        }
  
        return new JsonResponse($result);
     }
}
