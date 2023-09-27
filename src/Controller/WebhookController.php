<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;


use App\Entity\UserEntity;
use App\Entity\ScheduleEntity;
use App\Entity\SchedulePaymentEntity;
use App\Entity\ScheduleFormEntity;

use App\Service\AuthService;


/**
 * @Route("/webhook")
 */
class WebhookController extends AbstractController
{
    /**
     * @Route("/", name="webhook_acuity_callback")
     */
    public function index(AuthService $authService, Request $request){

        $em = $this->getDoctrine()->getManager();
         // Compare the two:
         $body = file_get_contents('php://input');
         $hash = base64_encode(hash_hmac('sha256', $body, '9c82d7706c2dea32d20f3a9d4dd1fdd1', true));
         
         // Compare the two:
         if (isset($_SERVER['HTTP_X_ACUITY_SIGNATURE']) && $hash !== $_SERVER['HTTP_X_ACUITY_SIGNATURE']) {
             throw new Exception('This message was forged!');
         }
        
        if(isset($_POST)){
            
          $id = $_POST['id'];
          //$id= '1083184479';
            try {
                $curl = curl_init();
    
                curl_setopt_array($curl, array(
                  CURLOPT_URL => 'https://acuityscheduling.com/api/v1/appointments/' . $id,
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => '',
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => 'GET',
                  CURLOPT_HTTPHEADER => array(
                    'Authorization: Basic MjcwMTk5MjE6OWM4MmQ3NzA2YzJkZWEzMmQyMGYzYTlkNGRkMWZkZDE=',
                    'Content-Type: application/x-www-form-urlencoded'
                  ),
                ));
                
                $response = curl_exec($curl);
                $record  = json_decode($response, true);
                curl_close($curl);

                $user = $em->getRepository(UserEntity::class)->findOneBy(['firstName' => $record['firstName'], 'lastName' => $record['lastName'], 'email' => $record['email'], 'isDeleted' => 0]);

                if($user){

                    $schedule  = $em->getRepository(ScheduleEntity::class)->findOneBy(['acuityId' => $record['id']]);

                    if(is_null($schedule)){

                        $createdDate = str_replace('T', ' ', $record['datetimeCreated']);
                        $createdDatetimeObj = new \DateTime($createdDate);
                        
                        $schedule = new ScheduleEntity();
                        $schedule->setAcuityId($record['id']);
                        $schedule->setScheduleDate($record['date']);
                        $schedule->setStartTime($record['time']);
                        $schedule->setEndTime($record['endTime']);
                        $schedule->setDateCreated($createdDatetimeObj);
                        $schedule->setPrice($record['price']);
                        $schedule->setIsPaid($record['paid'] == 'yes' ? true: false);
                        $schedule->setScheduleType($record['type']);
                        $schedule->setCalendar($record['calendar']);
                        $schedule->setCalendarTimeZone($record['calendarTimezone']);
                        $schedule->setAcuityTimeZone($record['timezone']);
                        $schedule->setConfirmationPage($record['confirmationPage']);
                        $schedule->setConfirmationPagePaymentLink($record['confirmationPagePaymentLink']);
                        $schedule->setCategory($record['category']);
                        $schedule->setUser($user);
                        $em->persist($schedule);
                        $em->flush();

                        if(isset($record['forms'])){

                            foreach($record['forms'] as $form){

                                if(isset($form['values'])){
                                    foreach($form['values'] as $formField){

                                        $scheduleFormField  = $em->getRepository(ScheduleFormEntity::class)->findOneBy(['fieldId' => $formField['fieldID'], 'schedule' => $schedule]);
                                        if(!$scheduleFormField){
                                            $scheduleFormField = new ScheduleFormEntity();
                                            $scheduleFormField->setScheduleFormId($form['id']);
                                            $scheduleFormField->setFormName($form['name']);
                                            $scheduleFormField->setFieldId($formField['fieldID']);
                                            $scheduleFormField->setFieldValue($formField['value']);
                                            $scheduleFormField->setFieldName($formField['name']);
                                            $scheduleFormField->setSchedule($schedule);
                                            $em->persist($scheduleFormField);
                                            $em->flush();
                                        }
                                    }
                                }

                            }
                        }

                        try {

                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                              CURLOPT_URL => 'https://acuityscheduling.com/api/v1/appointments/' . $id . '/payments',
                              CURLOPT_RETURNTRANSFER => true,
                              CURLOPT_ENCODING => '',
                              CURLOPT_MAXREDIRS => 10,
                              CURLOPT_TIMEOUT => 0,
                              CURLOPT_FOLLOWLOCATION => true,
                              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                              CURLOPT_CUSTOMREQUEST => 'GET',
                              CURLOPT_HTTPHEADER => array(
                                'Authorization: Basic MjcwMTk5MjE6OWM4MmQ3NzA2YzJkZWEzMmQyMGYzYTlkNGRkMWZkZDE=',
                                'Content-Type: application/x-www-form-urlencoded'
                              ),
                            ));
                            
                            $paymentResponse = curl_exec($curl);
                            $paymentRecords = json_decode($paymentResponse, true);

                            if(count($paymentRecords)){
                                
                                foreach ($paymentRecords as $paymentRecord) {
                                
                                    $payment = $em->getRepository(SchedulePaymentEntity::class)->findOneBy(['transactionId' => $paymentRecord['transactionID']]);
                                    if(is_null($payment)){
        
                                        $paymentDate = str_replace('T', ' ', $paymentRecord['created']);
                                        $paymentDatetimeObj = new \DateTime($createdDate);
        
                                        $payment = new SchedulePaymentEntity();
                                        $payment->setTransactionId($paymentRecord['transactionID']);
                                        $payment->setPaymentDate($paymentDatetimeObj);
                                        $payment->setAmount($paymentRecord['amount']);
                                        $payment->setPaymentGateway($paymentRecord['processor']);
                                        $payment->setSchedule($schedule);
                                        $em->persist($payment);
                                        $em->flush();
                                    }
        
                                    curl_close($curl);
                                }
                            }
                     

                        } catch(Exception $e){
                            throw new Exception("Theres an error",0,$e);
                        }

                    }
                }
            }
            catch(Exception $e){
                throw new Exception("Theres an error",0,$e);
            }
        }

        return $this->render('Dashboard/index.html.twig');
    }
}
