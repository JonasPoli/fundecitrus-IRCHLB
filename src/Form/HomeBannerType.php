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
                'required' => false,
                'attr' => ['placeholder' => 'Ex: October 26-29, 2027'],
            ])
            ->add('subtitle', null, [
                'label' => 'Subtítulo do Banner',
                'required' => false,
                'attr' => ['placeholder' => 'Ex: VIII International Research'],
            ])
            ->add('mainTitle', null, [
                'label' => 'Título Principal (Linha 1)',
                'required' => false,
                'attr' => ['placeholder' => 'Ex: Conference on Huanglongbing'],
            ])
            ->add('mainTitleLine2', null, [
                'label' => 'Título Principal (Linha 2)',
                'required' => false,
                'attr' => ['placeholder' => 'Ex: & XXIV IOCV Conference'],
            ])
            ->add('titleFontSize', \Symfony\Component\Form\Extension\Core\Type\ChoiceType::class, [
                'label' => 'Tamanho da Fonte do Título',
                'choices' => [
                    'Padrão (Grande / Default)' => 'text-3xl sm:text-4xl md:text-6xl lg:text-7xl',
                    'Extra Grande' => 'text-4xl sm:text-5xl md:text-7xl lg:text-8xl',
                    'Médio' => 'text-2xl sm:text-3xl md:text-5xl lg:text-6xl',
                    'Pequeno (Para textos longos)' => 'text-xl sm:text-2xl md:text-4xl lg:text-5xl',
                ],
                'placeholder' => 'Selecione o tamanho...',
                'required' => false,
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
