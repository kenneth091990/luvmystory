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

class ProfileForm extends AbstractType
{
   
    private $manager;

    public function __construct(ObjectManager $manager) {
        $this->manager = $manager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {



        $builder
            ->add('email', EmailType::class, array(
                'label' => 'Email',
                'label_attr' => array(
                    'class' => 'middle required'
                ),
                'attr' => [ 'class' => 'form-control', 'required' => 'required', 'placeholder' => 'Enter Your Email Address', 'readonly' => true],
                'required' => true,
            ))
            ->add('first_name', TextType::class, array(
                'label' => 'First Name',
                'label_attr' => array(
                    'class' => 'middle required'
                ),
                'attr' => [ 'class' => 'form-control', 'required' => 'required', 'placeholder' => ''],
                'required' => true,
            ))
            ->add('last_name', TextType::class, array(
                'label' => 'Last Name',
                'label_attr' => array(
                    'class' => 'middle required'
                ),
                'attr' => [ 'class' => 'form-control', 'required' => 'required', 'placeholder' => ''],
                'required' => true
            ))
            
            ->add('phone_no', TextType::class, array(
                'label' => 'Phone No.',
                'label_attr' => array(
                    'class' => 'middle required'
                ),
                'attr' => [ 'class' => 'form-control', 'required' => 'required', 'placeholder' => ''],
                'required' => true
            ))
            ->add('birth_date', TextType::class, array(
                'label' => 'Birth Date',
                'label_attr' => array(
                    'class' => 'middle'
                ),
                'attr' => array('class' => 'form-control datepicker'),
                'required' => false
            ))
            ->add('facebook_url', TextType::class, array(
                'label' => 'Facebook Link',
                'label_attr' => array(
                    'class' => 'middle'
                ),
                'attr' => array('class' => 'form-control'),
                'required' => false
            ))
            ->add('twitter_url', TextType::class, array(
                'label' => 'Twitter Link',
                'label_attr' => array(
                    'class' => 'middle'
                ),
                'attr' => array('class' => 'form-control'),
                'required' => false
            ))
            ->add('instagram_url', TextType::class, array(
                'label' => 'Instagram Link',
                'label_attr' => array(
                    'class' => 'middle'
                ),
                'attr' => array('class' => 'form-control'),
                'required' => false
            ))
            ->add('gender', ChoiceType::class, [
                'choices'  => [
                    'Male' => 'Male',
                    'Female' => 'Female'
                ],
            ])
            ->add('country', ChoiceType::class, [
                'choices'  => [
                    '' => '',
                    "Afghanistan" => "Afghanistan",
                    "Albania" => "Albania",
                    "Algeria" => "Algeria",
                    "American Samoa" => "American Samoa",
                    "Andorra" => "Andorra",
                    "Angola" => "Angola",
                    "Anguilla" => "Anguilla",
                    "Antarctica" => "Antarctica",
                    "Antigua and Barbuda" => "Antigua and Barbuda",
                    "Argentina" => "Argentina",
                    "Armenia" => "Armenia",
                    "Aruba" => "Aruba",
                    "Australia" => "Australia",
                    "Austria" => "Austria",
                    "Azerbaijan" => "Azerbaijan",
                    "Bahamas" => "Bahamas",
                    "Bahrain" => "Bahrain",
                    "Bangladesh" => "Bangladesh",
                    "Barbados" => "Barbados",
                    "Belarus" => "Belarus",
                    "Belgium" => "Belgium",
                    "Belize" => "Belize",
                    "Belize" => "Benin",
                    "Bermuda" => "Bermuda",
                    "Bhutan" => "Bhutan",
                    "Bolivia" => "Bolivia",
                    "Bosnia and Herzegovina" => "Bosnia and Herzegovina",
                    "Botswana" => "Botswana",
                    "Bouvet Island" => "Bouvet Island",
                    "Brazil" => "Brazil",
                    "British Antarctic Territor" => "British Antarctic Territory",
                    "British Indian Ocean Territory" => "British Indian Ocean Territory",
                    "British Virgin Islands" => "British Virgin Islands",
                    "Brunei" => "Brunei",
                    "Bulgaria" => "Bulgaria",
                    "Burkina Faso" => "Burkina Faso",
                    "Burundi" => "Burundi",
                    "Cambodia" => "Cambodia",
                    "Cameroon" => "Cameroon",
                    "Canada" => "Canada",
                    "Canton and Enderbury Islands" => "Canton and Enderbury Islands",
                    "Cape Verde" => "Cape Verde",
                    "Cayman Islands" => "Cayman Islands",
                    "Central African Republic" => "Central African Republic",
                    "Chad" => "Chad",
                    "Chile" => "Chile",
                    "China" => "China",
                    "Christmas Island" => "Christmas Island",
                    "Cocos [Keeling] Islands" => "Cocos [Keeling] Islands",
                    "Colombia" => "Colombia",
                    "Comoros" => "Comoros",
                    "Congo - BrazzavilleG" => "Congo - Brazzaville",
                    "Congo - Kinshasa" => "Congo - Kinshasa",
                    "Cook Islands" => "Cook Islands",
                    "Costa Rica" => "Costa Rica",
                    "Croatia" => "Croatia",
                    "Cuba" => "Cuba",
                    "Cyprus" => "Cyprus",
                    "Czech Republic" => "Czech Republic",
                    "Côte d’Ivoire" => "Côte d’Ivoire",
                    "Denmark" => "Denmark",
                    "Djibouti" => "Djibouti",
                    "Dominica" => "Dominica",
                    "Dominican Republic" => "Dominican Republic",
                    "Dronning Maud Land" => "Dronning Maud Land",
                    "East Germany" => "East Germany",
                    "Ecuador" => "Ecuador",
                    "Egypt" => "Egypt",
                    "El Salvador" => "El Salvador",
                    "Equatorial Guinea" => "Equatorial Guinea",
                    "Eritrea" => "Eritrea",
                    "Estonia" => "Estonia",
                    "Ethiopia" => "Ethiopia",
                    "Falkland Islands" => "Falkland Islands",
                    "Faroe Islands" => "Faroe Islands",
                    "Fiji" => "Fiji",
                    "Finland" => "Finland",
                    "France" => "France",
                    "French Guian" => "French Guiana",
                    "PFrench PolynesiaF" => "French Polynesia",
                    "French Southern Territories" => "French Southern Territories",
                    "French Southern and Antarctic Territories" => "French Southern and Antarctic Territories",
                    "Gabon" => "Gabon",
                    "Gambia" => "Gambia",
                    "Georgia" => "Georgia",
                    "Germany" => "Germany",
                    "Ghana" => "Ghana",
                    "Gibraltar" => "Gibraltar",
                    "Greece" => "Greece",
                    "Greenland" => "Greenland",
                    "Grenada" => "Grenada",
                    "Guadeloupe" => "Guadeloupe",
                    "Guam" => "Guam",
                    "Guatemala" => "Guatemala",
                    "Guernsey" => "Guernsey",
                    "Guinea" => "Guinea",
                    "Guinea-Bissau" => "Guinea-Bissau",
                    "Guyana" => "Guyana",
                    "Haiti" => "Haiti",
                    "Heard Island and McDonald Islands" => "Heard Island and McDonald Islands",
                    "Honduras" => "Honduras",
                    "Hong Kong SAR China" => "Hong Kong SAR China",
                    "Hungary" => "Hungary",
                    "Iceland" => "Iceland",
                    "India" => "India",
                    "Indonesia" => "Indonesia",
                    "Iran" => "Iran",
                    "Iran" => "Iraq",
                    "Ireland" => "Ireland",
                    "Isle of Man" => "Isle of Man",
                    "Israel" => "Israel",
                    "Italy" => "Italy",
                    "Jamaica" => "Jamaica",
                    "Japan" => "Japan",
                    "Jersey" => "Jersey",
                    "Johnston Island" => "Johnston Island",
                    "Jordan" => "Jordan",
                    "Kazakhstan" => "Kazakhstan",
                    "Kenya" => "Kenya",
                    "Kiribati" => "Kiribati",
                    "Kuwait" => "Kuwait",
                    "Kyrgyzstan" => "Kyrgyzstan",
                    "Laos" => "Laos",
                    "Latvia" => "Latvia",
                    "Lebanon" => "Lebanon",
                    "Lesotho" => "Lesotho",
                    "Liberia" => "Liberia",
                    "Libya" => "Libya",
                    "Liechtenstein" => "Liechtenstein",
                    "Lithuania" => "Lithuania",
                    "Luxembourg" => "Luxembourg",
                    "Macau SAR China" => "Macau SAR China",
                    "Macedonia" => "Macedonia",
                    "Madagascar" => "Madagascar",
                    "Malawi" => "Malawi",
                    "Malaysia" => "Malaysia",
                    "Maldives" => "Maldives",
                    "Mali" => "Mali",
                    "Malta" => "Malta",
                    "Marshall Islands" => "Marshall Islands",
                    "Martinique" => "Martinique",
                    "Mauritania" => "Mauritania",
                    "Mauritius" => "Mauritius",
                    "Mayotte" => "Mayotte",
                    "Metropolitan France" => "Metropolitan France",
                    "Mexico" => "Mexico",
                    "Micronesia" => "Micronesia",
                    "Midway Islands" => "Midway Islands",
                    "Moldova" => "Moldova",
                    "Monaco" => "Monaco",
                    "Mongolia" => "Mongolia",
                    "Montenegro" => "Montenegro",
                    "Montserrat" => "Montserrat",
                    "Morocco" => "Morocco",
                    "Mozambique" => "Mozambique",
                    "Myanmar [Burma]" => "Myanmar [Burma]",
                    "NNamibiaA" => "Namibia",
                    "Nauru" => "Nauru",
                    "Nepal" => "Nepal",
                    "NetherlandsNL" => "Netherlands",
                    "Netherlands Antilles" => "Netherlands Antilles",
                    "Neutral Zone" => "Neutral Zone",
                    "New Caledonia" => "New Caledonia",
                    "New Zealand" => "New Zealand",
                    "Nicaragua" => "Nicaragua",
                    "Niger" => "Niger",
                    "Nigeria" => "Nigeria",
                    "Niue" => "Niue",
                    "Norfolk Island" => "Norfolk Island",
                    "North Korea" => "North Korea",
                    "North Vietnam" => "North Vietnam",
                    "Northern Mariana Islands" => "Northern Mariana Islands",
                    "Norway" => "Norway",
                    "Oman" => "Oman",
                    "Pacific Islands Trust Territory" => "Pacific Islands Trust Territory",
                    "Pakistan" => "Pakistan",
                    "Palau" => "Palau",
                    "Palestinian Territories" => "Palestinian Territories",
                    "Panama" => "Panama",
                    "Panama Canal Zone" => "Panama Canal Zone",
                    "Papua New Guinea" => "Papua New Guinea",
                    "Paraguay" => "Paraguay",
                    "People's Democratic Republic of Yemen" => "People's Democratic Republic of Yemen",
                    "Peru" => "Peru",
                    "Philippines" => "Philippines",
                    "Pitcairn Islands" => "Pitcairn Islands",
                    "Poland" => "Poland",
                    "Portugal" => "Portugal",
                    "Puerto Rico" => "Puerto Rico",
                    "Qatar" => "Qatar",
                    "Romania" => "Romania",
                    "Russia" => "Russia",
                    "Russia" => "Rwanda",
                    "Réunion" => "Réunion",
                    "Saint Barthélemy" => "Saint Barthélemy",
                    "Saint Helena" => "Saint Helena",
                    "Saint Kitts and Nevis" => "Saint Kitts and Nevis",
                    "Saint Lucia" => "Saint Lucia",
                    "Saint Martin" => "Saint Martin",
                    "Saint Pierre and Miquelon" => "Saint Pierre and Miquelon",
                    "Saint Vincent and the Grenadines" => "Saint Vincent and the Grenadines",
                    "Samoa" => "Samoa",
                    "San Marino" => "San Marino",
                    "Saudi Arabia" => "Saudi Arabia",
                    "Senegal" => "Senegal",
                    "Serbia" => "Serbia",
                    "Serbia and Montenegro" => "Serbia and Montenegro",
                    "Seychelles" => "Seychelles",
                    "Sierra Leone" => "Sierra Leone",
                    "Singapore" => "Singapore",
                    "Slovakia" => "Slovakia",
                    "Slovenia" => "Slovenia",
                    "Solomon Islands" => "Solomon Islands",
                    "Somalia" => "Somalia",
                    "South Afric" => "South Africa",
                    "South Georgia and the South Sandwich Islands" => "South Georgia and the South Sandwich Islands",
                    "South Korea" => "South Korea",
                    "Spain" => "Spain",
                    "Spain" => "Sri Lanka",
                    "Sudan" => "Sudan",
                    "Suriname" => "Suriname",
                    "Svalbard and Jan Mayen" => "Svalbard and Jan Mayen",
                    "Swaziland" => "Swaziland",
                    "Sweden" => "Sweden",
                    "Switzerland" => "Switzerland",
                    "Syria" => "Syria",
                    "São Tomé and Príncipe" => "São Tomé and Príncipe",
                    "Taiwan" => "Taiwan",
                    "Tajikistan" => "Tajikistan",
                    "Tanzania" => "Tanzania",
                    "Thailand" => "Thailand",
                    "Timor-Leste" => "Timor-Leste",
                    "Togo" => "Togo",
                    "Tokelau" => "Tokelau",
                    "Tonga" => "Tonga",
                    "Trinidad and Tobago" => "Trinidad and Tobago",
                    "Tunisia" => "Tunisia",
                    "Turkey" => "Turkey",
                    "Turkmenistan" => "Turkmenistan",
                    "Turks and Caicos Islands" => "Turks and Caicos Islands",
                    "Tuvalu" => "Tuvalu",
                    "U.S. Minor Outlying Islands" => "U.S. Minor Outlying Islands",
                    "U.S. Miscellaneous Pacific Islands" => "U.S. Miscellaneous Pacific Islands",
                    "U.S. Virgin Islands" => "U.S. Virgin Islands",
                    "Uganda" => "Uganda",
                    "Ukraine" => "Ukraine",
                    "Union of Soviet Socialist Republics" => "Union of Soviet Socialist Republics",
                    "United Arab Emirates" => "United Arab Emirates",
                    "United Kingdom" => "United Kingdom",
                    "United States" => "United States",
                    "Unknown or Invalid Region" => "Unknown or Invalid Region",
                    "Uruguay" => "Uruguay",
                    "Uzbekistan" => "Uzbekistan",
                    "Vanuatu" => "Vanuatu",
                    "Vatican City" => "Vatican City",
                    "Venezuela" => "Venezuela",
                    "Vietnam" => "Vietnam",
                    "Wake Island" => "Wake Island",
                    "Wallis and Futuna" => "Wallis and Futuna",
                    "Western Sahar" => "Western Sahara",
                    "Yemen" => "Yemen",
                    "Zambia" => "Zambia",
                    "Zimbabwe" => "Zimbabwe",
                    "Åland Island" => "Åland Islands"
                ],
            ])
            ->add('zodiac_sign', ChoiceType::class, [
                'choices'  => [
                    '' => '',
                    'Capricorn' => 'Capricorn',
                    'Aquarius'  => 'Aquarius',
                    'Pisces'  => 'Pisces',
                    'Aries'  => 'Aries',
                    'Taurus'  => 'Taurus',
                    'Gemini'  => 'Gemini',
                    'Cancer'  => 'Cancer',
                    'Leo'  => 'Leo',
                    'Virgo'  => 'Virgo',
                    'Libra'  => 'Libra', 
                    'Scorpio'  => 'Scorpio',  
                    'Sagittarius'  => 'Sagittarius', 
                    'Capricorn'  => 'Capricorn'
                ],
                'required' => false
            ])
            ->add('bio', TextareaType::class, array(
                'label' => '',
                'label_attr' => array(
                    'class' => 'middle required'
                ),
                'attr' => [ 'class' => 'form-control', 'required' => 'required', 'placeholder' => 'Write a bio', 'rows' => 5],
                'required' => true
            ))
            
            
            ->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) {

                $form = $event->getForm();
                $data = $event->getData();
            });

            $builder->get('birth_date')->addModelTransformer(new DateTimeTransformer());


    }

    public function getName()
    {
        return 'profile';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' 	  => 'App\Entity\UserEntity',
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            // a unique key to help generate the secret token
            'intention'       => 'UserEntity_intention'
        ));
    }
}