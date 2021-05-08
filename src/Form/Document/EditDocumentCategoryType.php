<?php
/**
 * Created by PhpStorm.
 * User: jsilaci
 * Date: 27.03.2017
 * Time: 15:22
 */

namespace App\Form\Document;

use App\Entity\Document\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EditDocumentCategoryType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
            ->add('id', HiddenType::class)
            ->add('name', TextType::class, [
                'label' => "Názov"
            ])
            ->add('code', TextType::class, [
                'label'      => "Kód",
                'required'   => false,
                'empty_data' => '' // v pripade, ze nic nezadam
            ])
            ->add('parent', EntityType::class,
                [
                    'class'        => 'App\Entity\Category',
                    'label' => "Nadradená kategória",
                    'choice_label' => 'name',
                    'expanded'     => false,
                    'attr'         => [
                        'class' => 'select2'
                    ],
                    'required' => false,
                ]
            )
            ->add('submit', SubmitType::class, array(
                'label' => 'Uložiť dokument',
                'attr' => array(
                    'class' => 'btn btn-info pull-right'
                ),
            ))
            ->setMethod('post');
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => Category::class,
        ));
    }
}