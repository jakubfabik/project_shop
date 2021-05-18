<?php
/**
 * Created by PhpStorm.
 * User: jsilaci
 * Date: 27.03.2017
 * Time: 15:22
 */

namespace App\Form\User;

use App\Entity\User\User;
use Doctrine\ORM\EntityManagerInterface;
#use SebastianBergmann\CodeCoverage\Report\Text;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class EditUserType extends AbstractType {

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder = null;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(UserPasswordEncoderInterface $encoder, EntityManagerInterface $em) {
        $this->passwordEncoder = $encoder;
        $this->entityManager = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
            ->add('id', HiddenType::class)
            ->add('username', TextType::class, [
                'label' => "Prihlasovacie meno (login)"
            ])
            ->add('firstName', TextType::class, [
                'label'      => "Meno",
                'required'   => false,
                'empty_data' => '' // v pripade, ze nic nezadam
            ])
            ->add('surname', TextType::class, [
                'label' => "Priezvisko",
                'required' => false,
                'empty_data' => ''
            ])
            ->add('email', EmailType::class, [
                'label' => "Mailová adresa"
            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => "Heslo (použije sa len v prípade, že nie je prázdne)",
                'empty_data' => '',
                'required' => false
            ])
            ->add('roleObjects', EntityType::class,
                [
                    'class'        => 'App\Entity\User\Role',
                    'choice_label' => 'name',
                    'multiple'     => true,
                    'expanded'     => false,
                    'attr'         => [
                        'class' => 'select2'
                    ],
                    'required' => true,
                ]
            )
            ->add('submit', SubmitType::class, array(
                'label' => 'Uložiť používateľa',
                'attr' => array(
                    'class' => 'btn btn-info pull-right'
                ),
            ))
            ->setMethod('post');
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }
}