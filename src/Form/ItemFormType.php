<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Conditions;
use App\Entity\Items;
use App\Entity\Subcategories;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ItemFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a name for your item',
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Your item\'name should be at least {{ limit }} characters',
                        'max' => 20,
                        'maxMessage' => 'Your item\'name cannot exceed {{ limit }} characters',
                    ])
                ]
            ])
            ->add('price', NumberType::class, [
                'required' => true,
                'constraints' => [
                    new Positive()
                ]
            ])
            ->add('stock', NumberType::class, [
                'required' => true,
                'constraints' => [
                    new Positive()
                ]
            ])
            ->add('description', TextareaType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a description',
                    ]),
                    new Length([
                        'min' => 50,
                        'minMessage' => 'Your description should be at least {{ limit }} characters',
                    ])
                ]
            ])
            ->add('category', EntityType::class, [
                'class' => Categories::class,
                'choice_label' => 'category',
                'required' => true,
            ])
            ->add('subcategory', EntityType::class, [
                'class' => Subcategories::class,
                'choice_label' => 'subcategory',
                'required' => true,
            ])
            ->add('status', EntityType::class, [
                'class' => Conditions::class,
                'choice_label' => 'status',
                'required' => true,
            ])
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => true,
                'delete_label' => 'Delete',
                'download_uri' => true,
                'download_label' => 'Upload',
                'image_uri' => true,
                'asset_helper' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Items::class,
            'sanitize_html' => true,
        ]);
    }
}
