<?php

namespace App\Form;

use App\Entity\HomeBanner;
use App\Form\ImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HomeBannerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('eventDate', null, [
                'label' => 'Data do Evento (Exibição)',
                'attr' => ['placeholder' => 'Ex: October 26-29, 2027'],
            ])
            ->add('subtitle', null, [
                'label' => 'Subtítulo do Banner',
                'required' => false,
                'attr' => ['placeholder' => 'Ex: VIII International Research'],
            ])
            ->add('mainTitle', null, [
                'label' => 'Título Principal',
                'attr' => ['placeholder' => 'Ex: Conference on Huanglongbing'],
            ])
            ->add('description1', null, [
                'label' => 'Descrição Curta / Destaque',
                'required' => false,
            ])
            ->add('description', null, [
                'label' => 'Descrição Detalhada',
                'required' => false,
            ])
            ->add('button1Text', null, [
                'label' => 'Texto do Botão 1',
                'required' => false,
                'attr' => ['placeholder' => 'Ex: Register Now'],
            ])
            ->add('button1Link', null, [
                'label' => 'Link do Botão 1',
                'required' => false,
                'attr' => ['placeholder' => 'Ex: /inscricoes ou https://...'],
            ])
            ->add('button2Text', null, [
                'label' => 'Texto do Botão 2',
                'required' => false,
                'attr' => ['placeholder' => 'Ex: Call for Papers'],
            ])
            ->add('button2Link', null, [
                'label' => 'Link do Botão 2',
                'required' => false,
                'attr' => ['placeholder' => 'Ex: /submissao ou https://...'],
            ])
            ->add('image', ImageType::class, [
                'label' => 'Imagem de Fundo do Banner',
                'required' => false,
            ])
            ->add('position', null, [
                'label' => 'Posição / Ordem',
            ])
            ->add('isActive', null, [
                'label' => 'Está Ativo / Publicado',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => HomeBanner::class,
        ]);
    }
}
