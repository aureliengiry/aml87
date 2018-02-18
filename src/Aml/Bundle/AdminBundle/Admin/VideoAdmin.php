<?php
namespace Aml\Bundle\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class VideoAdmin
 * @package Aml\Bundle\AdminBundle\Admin
 */
class VideoAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        // get the current Post instance
        $video = $this->getSubject();

        // use $thumbnailFieldOptions so we can add other options to the field
        $thumbnailFieldOptions = array(
            'required' => false,
            'label' => 'Référence Youtube'
        );
        if ($video) {
            // add a 'help' option containing the preview's img tag
            $providerId = $video->getProviderId();

            $urlVideo = "https://www.youtube.com/embed/{$providerId}";
            $thumbnailFieldOptions['help'] = '<p>Lien Youtube: https://www.youtube.com/watch?v=<strong>'.$providerId.'</strong></p><iframe width="500" height="369"
src="'.$urlVideo.'" frameborder="0" allowfullscreen></iframe>';
        }

        $formMapper
            ->with('General')
            ->add(
                'title',
                'text',
                array(
                    'required' => false,
                )
            )
            ->add('provider_id', 'text', $thumbnailFieldOptions)
            ->end()
            ->with('Evénements')
            ->add(
                'evenements',
                'sonata_type_model',
                array(
                    'required' => false,
                    'expanded' => true,
                    'multiple' => true,
                    'by_reference' => false
                )
            )
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {

    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('thumbnail', 'string', array('template' => 'AmlAdminBundle:Admin:list_thumbnail.html.twig'))
            ->add('title')
            ->addIdentifier('provider_id');
    }
}
