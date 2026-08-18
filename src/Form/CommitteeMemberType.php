<?php

namespace App\Form;

use App\Entity\CommitteeMember;
use App\Form\ImageType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommitteeMemberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Nome Completo'])
            ->add('email', EmailType::class, [
                'label' => 'E-mail',
                'required' => false,
            ])
            ->add('committees', ChoiceType::class, [
                'label' => 'Comitês / Grupos',
                'choices' => [
                    'Steering Committee' => 'Steering Committee',
                    'General Organizing Committee' => 'General Organizing Committee',
                    'Scientific Committee' => 'Scientific Committee',
                ],
                'multiple' => true,
                'expanded' => true,
                'required' => false,
                'help' => 'Selecione um ou mais comitês dos quais este membro faz parte.',
            ])
            ->add('role', null, [
                'label' => 'Cargo / Função'])
            ->add('institution', null, [
                'label' => 'Instituição de Vínculo'])
            ->add('bio', null, [
                'label' => 'Biografia Resumida'])
            ->add('academicLink', null, [
                'label' => 'Link de Currículo Acadêmico'])
            ->add('linkedinUrl', null, [
                'label' => 'Link do LinkedIn'])
            ->add('groupType', null, [
                'label' => 'Subgrupo / País (Subdivisão para Steering Committee)',
                'required' => false,
            ])
            ->add('active', \Symfony\Component\Form\Extension\Core\Type\CheckboxType::class, [
                'label' => 'Ativo (Exibir no site)',
                'required' => false,
            ])
            ->add('position', HiddenType::class)
            ->add('image', ImageType::class, [
                'label' => 'Foto de Perfil',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CommitteeMember::class,
        ]);
    }
}
