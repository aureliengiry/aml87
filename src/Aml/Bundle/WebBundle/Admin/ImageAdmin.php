<?php
namespace Aml\Bundle\WebBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class ImageAdmin
 * @package Aml\Bundle\WebBundle\Admin
 */
class ImageAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $image = $this->getSubject();

        $fileFieldOptions = [
            'required'   => false,
            'image_path' => 'webPath',
        ];
        if ($image) {
            $path = $image->getPath();

            if ($path) {
                // add a 'help' option containing the preview's img tag
                $fileFieldOptions['help'] =
                    '<img style="max-width:100%;" src="/' . $image->getWebPath() . '" class="admin-preview" />';
            }
        }
        $formMapper
            ->add(
                'title',
                'text',
                [
                    'required' => false,
                ]
            )
            ->add('file', 'file', $fileFieldOptions);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {

    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('file', 'string', ['template' => 'AmlWebBundle:Admin:list_image.html.twig'])
            ->addIdentifier('title', 'Image');
    }
}
