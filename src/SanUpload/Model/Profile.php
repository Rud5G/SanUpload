<?php

namespace SanUpload\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Profile implements InputFilterAwareInterface
{
    public $profilename;
    public $fileupload;
    protected $inputFilter;
    
    public function exchangeArray($data)
    {
        $this->profilename  = (isset($data['profilename']))  ? $data['profilename']     : null; 
        $this->fileupload  = (isset($data['fileupload']))  ? $data['fileupload']     : null; 
    } 
    
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }
    
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();
             
            $inputFilter->add(
                $factory->createInput(array(
                    'name'     => 'profilename',
                    'required' => true,
                    'filters'  => array(
                        array('name' => 'StripTags'),
                        array('name' => 'StringTrim'),
                    ),
                    'validators' => array(
                        array(
                            'name'    => 'StringLength',
                            'options' => array(
                                'encoding' => 'UTF-8',
                                'min'      => 1,
                                'max'      => 100,
                            ),
                        ),
                    ),
                ))
            );
                        
            $inputFilter->add(
                $factory->createInput(array(
                    'name'     => 'fileupload',
                    'required' => true,
                    /*'validators' => array(
                        array(
                            'name'    => 'File\Upload',
                            'options'   => array (
                                'files' => $_FILES,
                            ),
                            'files' => $_FILES,
                        ),
                        array(
                            'name'    => 'File\IsImage',
                            'options' => array(
                                'mimeType' => array('image/jpeg') ,
                            )
                        ),
                    ),
                    'files' => (isset($_FILES['fileupload'])) ? $_FILES : null,
                    */
                ))
            );
            
            $this->inputFilter = $inputFilter;
        }
        
        return $this->inputFilter;
    }
    
}