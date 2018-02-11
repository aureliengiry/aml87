<?php
namespace Aml\Bundle\WebBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class FileAdmin
 * @package Aml\Bundle\WebBundle\Admin
 */
class FileAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title')
            ->add(
                'file',
                'file',
                [
                    'required' => false,
                ]
            );
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {

    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title');
    }
}
