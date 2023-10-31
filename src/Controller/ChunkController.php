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
 * @Route("/chunk")
 */
class ChunkController extends AbstractController
{
    /**
     * @Route("/upload_story", name="chunk_upload_story")
     */
    public function upload_story(AuthService $authService){

        
        
        $result = [];
        if(!$authService->isLoggedIn()){
            $result['success'] = false;
            $result['msg'] = 'Unauthorized access please call a system administrator.';
        } else {


            $targetDir =  dirname(__DIR__, 2) . '/public/tmp'; 
            $cleanupTargetDir = true; // Remove old files 
            $maxFileAge = 5 * 3600; // Temp file age in seconds 

            // Create target dir 
            if (!file_exists($targetDir)) { 
                @mkdir($targetDir); 
            } 
             
            // // Get a file name 
            if (isset($_REQUEST["name"])) { 
                $fileName = $_REQUEST["name"]; 
            } elseif (!empty($_FILES)) { 
                $fileName = $_FILES["file"]["name"]; 
            } else { 
                $fileName = uniqid("file_"); 
            } 
             
            $filePath = $targetDir . '/' . $fileName; 
             
            // Chunking might be enabled 
            $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0; 
            $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0; 
             
            // // Remove old temp files     
            if ($cleanupTargetDir) { 
                if (!is_dir($targetDir) || !$dir = opendir($targetDir)) { 
                    $result = ['success' => false , 'code' => 101, 'msg' => 'Opps something went wrong while uploading file.'];
                } 

                while (($file = readdir($dir)) !== false) { 

                    $tmpfilePath = $targetDir . '/' . $file; 
                

                    // If temp file is current file proceed to the next 
                    if ($tmpfilePath == "{$filePath}.part") { 
                        continue; 
                    } 
             
                    
                    // // Remove temp file if it is older than the max age and is not the current file 
                    if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge)) { 
                        @unlink($tmpfilePath); 

                    } 
                } 

                closedir($dir); 

            }     
             

            // // Open temp file 

            if (!$out = @fopen("{$filePath}.part", $chunks ? "ab" : "wb")) { 
                $result = ['success' => false , 'code' => 101, 'msg' => 'Opps something went wrong while uploading file.'];
            } 

            if (!empty($_FILES)) { 

                if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) { 
                    $result = ['success' => false , 'code' => 101, 'msg' => 'Opps something went wrong while uploading file.'];
                } 
             
                // Read binary input stream and append it to temp file 
                if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) { 
                    $result = ['success' => false , 'code' => 101, 'msg' => 'Opps something went wrong while uploading file.'];
                } 
            } else {     
                if (!$in = @fopen("php://input", "rb")) { 
                    
                    $result = ['success' => false , 'code' => 101, 'msg' => 'Opps something went wrong while uploading file.'];
                } 
            } 
             
            while ($buff = fread($in, 4096)) { 
                fwrite($out, $buff); 
            } 
             
            @fclose($out); 
            @fclose($in); 
             
            // Check if file has been uploaded 
            if (!$chunks || $chunk == $chunks - 1) { 
                // Strip the temp .part suffix off  
                $em = $this->getDoctrine()->getManager();
                $schedule = $em->getRepository(ScheduleEntity::class)->find(base64_decode($_REQUEST['id']));

                if($schedule){
                    $stringParts = explode('/', $filePath);
                    $fileName = array_pop($stringParts);

                    $baseName = $schedule->getId() . '-' . time() . '-' . $fileName;
                    $uploadFile = dirname(__DIR__, 2)  . '/public/uploads/audio/' . $baseName;
           
                    $schedule->removeFile();
                    $schedule->setFileDesc($_FILES['file']['name']);
                    $schedule->setParsedFileDesc($baseName);           
                    $em->flush();

                    $result['fileWebPath'] = $schedule->getFileWebPath();
                    
                    rename("{$filePath}.part", $uploadFile); 

                }

            } 
             
            $result['success'] = true; 
            $result['code'] = 200;
            $result['msg'] = 'The file has been uploaded successfully!';
        }

        return new JsonResponse($result);
    }


    
}
