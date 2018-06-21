<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class ImageAdmin.
 */
class ImageAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $image = $this->getSubject();

        $fileFieldOptions = [
            'required' => false,
            'image_path' => 'webPath',
        ];
        if ($image) {
            $path = $image->getPath();

            if ($path) {
                // add a 'help' option containing the preview's img tag
                $fileFieldOptions['help'] =
                    '<img style="max-width:100%;" src="/'.$image->getWebPath().'" class="admin-preview" />';
            }
        }
        $formMapper
            ->add(
                'title',
                TextType::class,
                [
                    'required' => false,
                ]
            )
            ->add('file', FileType::class, $fileFieldOptions);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('file', 'string', ['template' => 'Admin/list_image.html.twig'])
            ->addIdentifier('title', 'Image');
    }
}
