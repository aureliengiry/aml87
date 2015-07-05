<?php
namespace Aml\Bundle\MediasBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;


class ImageAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $image = $this->getSubject();

        $fileFieldOptions = array(
            'required' => false,
            'image_path' => 'webPath'
        );
        if ($image) {
            $path = $image->getPath();

            if ($path) {
                // add a 'help' option containing the preview's img tag
                $fileFieldOptions['help'] =
                    '<img style="max-width:100%;" src="/' . $image->getWebPath() . '" class="admin-preview" />';
            }
        }
        $formMapper
            ->add('title','text',array(
                'required' => false,
            ))
            ->add('file','file' , $fileFieldOptions)
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {

    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('file', 'string', array('template' => 'AmlMediasBundle:Admin:list_image.html.twig'))
            ->addIdentifier('title','Image')
        ;
    }



}