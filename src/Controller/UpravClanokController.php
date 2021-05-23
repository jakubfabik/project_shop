<?php
namespace App\Controller;

use App\Entity\Clanok;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UpravClanokController extends AbstractType {

public function buildForm(FormBuilderInterface $builder, array $options) {

$builder
->add('id', HiddenType::class, ['mapped' => false])
->add('nazov', TextType::class, [
'label' => "Názov"
])

->add('text', TextareaType::class, [
'label' => "Obsah",
'required' => false,
'empty_data' => '',
'attr' => [
'class' => 'ckeditor'
]
])
->add('submit', SubmitType::class, array(
'label' => 'Uložiť článok',
'attr' => array(
'class' => 'btn btn-info pull-right'
),
))
->setMethod('post');
}

public function configureOptions(OptionsResolver $resolver) {
$resolver->setDefaults(array(
'data_class' => Clanok::class,
));
}
}
