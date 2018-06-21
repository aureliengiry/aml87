<?php

namespace App\Admin;

use App\Entity\Evenement;
use App\Entity\Season;
use App\Entity\UrlEvenement;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\AdminType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\CoreBundle\Form\Type\DateTimePickerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class EvenementAdmin.
 *
 * @author      Aurélien GIRY <aurelien.giry@gmail.com>
 */
class EvenementAdmin extends AbstractAdmin
{
    // setup the default sort column and order
    protected $datagridValues = [
        '_sort_order' => 'DESC',
        '_sort_by' => 'dateStart',
    ];

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
            ->add(
                'title',
                TextType::class,
                [
                    'label' => 'Titre',
                ]
            )
            ->add(
                'type',
                ChoiceType::class,
                [
                    'label' => 'Type d\'événement',
                    'choices' => Evenement::getTypesEvenements(),
                    'multiple' => false,
                    'placeholder' => 'Sélectionnez le type d\'événement',
                ]
            )
            ->add(
                'season',
                EntityType::class,
                [
                    'label' => 'Saison',
                    'class' => Season::class,
                    'choice_label' => 'name',
                    'placeholder' => 'Sélectionnez une saison',
                    'attr' => ['class' => 'uiform'],
                ]
            )
            ->add(
                'dateStart',
                DateTimePickerType::class,
                [
                    'dp_side_by_side' => true,
                    'dp_use_current' => false,
                    'dp_use_seconds' => false,
                    'dp_language' => 'fr',
                    'format' => 'dd/MM/yyyy HH:mm',
                ]
            )
            ->add(
                'picture',
                AdminType::class,
                [
                    'delete' => false,
                    'required' => false,
                ]
            )
            ->add(
                'description',
                CKEditorType::class,
                [
                    'required' => false,
                    'config_name' => 'aml_config',
                ]
            )
            ->add(
                'archive',
                CheckboxType::class,
                [
                    'label' => 'Archiver',
                    'required' => false,
                ]
            )
            ->add(
                'public',
                CheckboxType::class,
                [
                    'label' => 'Publier',
                    'required' => false,
                ]
            )
            ->end()
            ->with('Articles')
            ->add(
                'articles',
                ModelType::class,
                [
                    'required' => false,
                    'expanded' => true,
                    'multiple' => true,
                    'by_reference' => false,
                ]
            )
            ->end()
            ->with('Vidéos')
            ->add(
                'videos',
                ModelType::class,
                [
                    'required' => false,
                    'expanded' => true,
                    'multiple' => true,
                    'by_reference' => false,
                ]
            )
            ->end()
            ->with('Partenaires')
            ->add(
                'partenaires',
                ModelType::class,
                [
                    'required' => false,
                    'expanded' => true,
                    'multiple' => true,
                    'by_reference' => false,
                ]
            )
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ->add('type');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->addIdentifier('type')
            ->addIdentifier('dateStart')
            ->add('archive')
            ->add('public');
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($evenement)
    {
        $urlKey = $evenement->getUrl();
        if (empty($urlKey)) {
            $entityUrl = new UrlEvenement();
            $entityUrl->setUrlKey($evenement->getTitle());

            $evenement->setUrl($entityUrl);
        } else {
            $urlKey->setUrlKey($evenement->getTitle());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function prePersist($evenement)
    {
        $entityUrl = new UrlEvenement();
        $entityUrl->setUrlKey($evenement->getTitle());

        $evenement->setUrl($entityUrl);
    }
}
