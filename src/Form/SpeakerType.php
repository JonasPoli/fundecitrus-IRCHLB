<?php

namespace App\Form;

use App\Entity\AgendaActivity;
use App\Entity\Speaker;
use App\Form\ImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpeakerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Nome Completo'])
            ->add('institution', null, [
                'label' => 'Instituição'])
            ->add('department', null, [
                'label' => 'Departamento / Faculdade'])
            ->add('shortBio', null, [
                'label' => 'Biografia Curta (Resumo)'])
            ->add('bio', null, [
                'label' => 'Biografia Completa (HTML Suportado)'])
            ->add('linkedinUrl', null, [
                'label' => 'Link do LinkedIn'])
            ->add('instagramUrl', null, [
                'label' => 'Link do Instagram'])
            ->add('facebookUrl', null, [
                'label' => 'Link do Facebook'])
            ->add('youtubeUrl', null, [
                'label' => 'Link do YouTube'])
            ->add('whatsappUrl', null, [
                'label' => 'Link de Contato do WhatsApp'])
            ->add('scholarUrl', null, [
                'label' => 'Link do Google Scholar'])
            ->add('lattesUrl', null, [
                'label' => 'Link do Currículo Lattes'])
            ->add('researchAreas', TextType::class, [
                'label' => 'Áreas de Pesquisa (Separadas por vírgula)',
                'required' => false,
            ])
            ->add('isFeatured', null, [
                'label' => 'Destaque / Palestrante Principal?'])
            ->add('position', HiddenType::class)
            ->add('image', ImageType::class, [
                'label' => 'Foto de Perfil',
                'required' => false,
            ])
            ->add('activities', EntityType::class, [
                'class' => AgendaActivity::class,
                'choice_label' => 'title',
                'multiple' => true,
                'label' => 'Sessões da Agenda Associadas',
                'required' => false,
            ])
        ;

        $builder->get('researchAreas')
            ->addModelTransformer(new CallbackTransformer(
                function ($tagsAsArray): string {
                    return implode(', ', $tagsAsArray ?? []);
                },
                function ($tagsAsString): array {
                    return array_filter(array_map('trim', explode(',', $tagsAsString ?? '')));
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Speaker::class,
        ]);
    }
}
