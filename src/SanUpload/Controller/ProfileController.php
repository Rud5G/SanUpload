<?php

namespace SanUpload\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel;
    
use SanUpload\Model\Profile,
    SanUpload\Form\ProfileForm;

use Zend\Validator\File\Size;

class ProfileController extends AbstractActionController
{
    public function addAction()
    {
        $form = new ProfileForm();
        $request = $this->getRequest();  
        if ($request->isPost()) {
            
            $profile = new Profile();
            $form->setInputFilter($profile->getInputFilter());
            
            $nonFile = $request->getPost()->toArray();
            $File    = $this->params()->fromFiles('fileupload');
            $data = array_merge(
                 $nonFile,
                 array('fileupload'=> $File['name'])
             );
            //set data post and file ...    
            $form->setData($data);
             
            if ($form->isValid()) {
                
               // $profile->exchangeArray($form->getData());
                $size = new Size(array('min'=>'0.001MB')); //2MB
                
                $adapter = new \Zend\File\Transfer\Adapter\Http();
                
                        $extensionvalidator = new \Zend\Validator\File\Extension(array('extension'=>array('jpg','png')));
                  //      $adapter->setValidators(array($extensionvalidator));                

                
                $adapter->setValidators(array($size,$extensionvalidator), $File['name']);
                if (!$adapter->isValid()){
                    $dataError = $adapter->getMessages();
                    $error = array();
                    foreach($dataError as $key=>$row)
                    {
                        $error[] = $row;
                    }
                    $form->setMessages(array('fileupload'=>$error ));
                } else {
                    $adapter->setDestination(dirname(__DIR__).'/assets');
                    if ($adapter->receive($File['name'])) {
                            $profile->exchangeArray($form->getData());
                            echo 'Profile Name '.$profile->profilename.' upload '.$profile->fileupload;
                    }
                }  
            } 
        }
         
        return array('form' => $form);
    }
}

//http://stackoverflow.com/questions/11690320/how-do-i-pass-file-and-post-data-into-a-form
