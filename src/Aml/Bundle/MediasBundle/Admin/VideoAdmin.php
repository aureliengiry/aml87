<?php
namespace Aml\Bundle\MediasBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;


class VideoAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title', 'text', array(
                'required' => false,
            ))
            ->add('provider_id', 'text', array(
                'required' => false,
            ));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {

    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('thumbnail', 'string', array('template' => 'AmlMediasBundle:Admin:list_thumbnail.html.twig'))
            ->add('title')
            ->addIdentifier('provider_id');
    }


}