<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class VideoAdmin
 * @package App\Admin
 */
class VideoAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        // get the current Post instance
        $video = $this->getSubject();

        // use $thumbnailFieldOptions so we can add other options to the field
        $thumbnailFieldOptions = [
            'required' => false,
            'label'    => 'Référence Youtube'
        ];
        if ($video) {
            // add a 'help' option containing the preview's img tag
            $providerId = $video->getProviderId();

            $urlVideo = "https://www.youtube.com/embed/{$providerId}";
            $thumbnailFieldOptions['help'] = '<p>Lien Youtube: https://www.youtube.com/watch?v=<strong>' . $providerId . '</strong></p><iframe width="500" height="369"
src="' . $urlVideo . '" frameborder="0" allowfullscreen></iframe>';
        }

        $formMapper
            ->with('General')
            ->add(
                'title',
                TextType::class,
                [
                    'required' => false,
                ]
            )
            ->add('provider_id', TextType::class, $thumbnailFieldOptions)
            ->end()
            ->with('Evénements')
            ->add(
                'evenements',
                ModelType::class,
                [
                    'required'     => false,
                    'expanded'     => true,
                    'multiple'     => true,
                    'by_reference' => false
                ]
            )
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {

    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('thumbnail', 'string', ['template' => 'Admin/list_thumbnail.html.twig'])
            ->add('title')
            ->addIdentifier('provider_id');
    }
}
