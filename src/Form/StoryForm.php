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
use App\Form\DataTransformer\DateTimeTransformer;

class StoryForm extends AbstractType
{
   
    private $manager;

    public function __construct(ObjectManager $manager) {
        $this->manager = $manager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

    }

    public function getName()
    {
        return 'story';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' 	  => 'App\Entity\StoryEntity',
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'allow_extra_fields' => true,
            // a unique key to help generate the secret token
            'intention'       => 'StoryEntity_intention'
        ));
    }
}