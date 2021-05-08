<?php
/**
 * Created by PhpStorm.
 * User: jsilaci
 * Date: 27.03.2017
 * Time: 15:22
 */

namespace App\Form\User;

use App\Form\Model\ChangePassword;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('newPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'invalid_message' => 'Nové heslá sa nezhodujú.',
                'options' => array('attr' => array('class' => 'password-field')),
                'required' => true,
                'first_options'  => array('label' => 'Nové heslo'),
                'second_options' => array('label' => 'Zopakovať nové heslo'),
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Zmeniť heslo',
                'attr' => array(
                    'class' => 'btn btn-primary pull-right'),
            ))
            ->setMethod('post');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => ChangePassword::class,
        ));
    }
}