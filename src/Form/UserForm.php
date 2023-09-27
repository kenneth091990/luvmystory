<?php

namespace App\Form;

use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

use App\Form\DataTransformer\DataTransformer;

class UserForm extends AbstractType
{
   
    private $manager;

    public function __construct(ObjectManager $manager) {
        $this->manager = $manager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $userTypes = array();

        foreach($options['userTypes'] as $row) {
            if($row !== 'Super Admin')
                $userTypes[$row] = $row;
        }

        $builder
            ->add('action', HiddenType::class, array(
                'mapped' => false,
                'attr' => array(
                    'class' => 'form-action'
                )
            ))
            ->add('id', HiddenType::class)
            ->add('email', TextType::class, array(
                'label' => 'Email',
                'label_attr' => array(
                    'class' => 'middle required'
                ),
                'required' => true,
                'attr' => [ 'class' => 'form-control', 'required' => 'required']
            ))
            ->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'required' => $options['action'] === 'n' ? true : false,
                'first_options' => array(
                    'label' => 'Password',
                    'label_attr' => array(
                        'class' => $options['action'] === 'n' ? 'required middle' : 'middle'
                    ),
                    'attr' => [ 'class' => 'form-control', 'required' =>  $options['action'] != 'u' ?  true : false ],
                    'empty_data' => ''  
                ),
                'second_options' => array(
                    'label' => 'Confirm Password',
                    'label_attr' => array(
                        'class' => $options['action'] === 'n' ? 'required middle' : 'middle'
                    ),
                    'attr' => [ 'class' => 'form-control']
                ),
                'label' => '',
                'empty_data' => ''

            ))
            ->add('first_name', TextType::class, array(
                'label' => 'First Name',
                'label_attr' => array(
                    'class' => 'middle required'
                ),
                'attr' => [ 'class' => 'form-control', 'required' => 'required'],
                'required' => true,
            ))
            ->add('last_name', TextType::class, array(
                'label' => 'Last Name',
                'label_attr' => array(
                    'class' => 'middle required'
                ),
                'attr' => [ 'class' => 'form-control', 'required' => 'required'],
                'required' => true
            ));

    }

    public function getName()
    {
        return 'user';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' 	  => 'App\Entity\UserEntity',
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            // a unique key to help generate the secret token
            'intention'       => 'userEntity_intention',
            'action'          => 'n',
            'userTypes'    => array()
        ));
    }
}