<?php
namespace App\Admin;

use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

use App\Entity\UrlDiscography;
use Sonata\AdminBundle\Form\Type\AdminType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\CoreBundle\Form\Type\DatePickerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class AlbumAdmin
 * @package App\Admin
 */
class AlbumAdmin extends AbstractAdmin
{
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
            ->add('image', AdminType::class)
            ->add(
                'description',
                CKEditorType::class,
                [
                    'label'       => 'Texte',
                    'attr'        => ['size' => 15, 'data-help' => 'Description de l\'album'],
                    'required'    => false,
                    'config_name' => 'aml_config',
                ]
            )
            ->add(
                'date',
                DatePickerType::class,
                [
                    'dp_side_by_side' => true,
                    'dp_use_current'  => false,
                    'dp_language'     => 'fr',
                    'format'          => 'dd/MM/yyyy',
                ]
            )
            ->add(
                'public',
                CheckboxType::class,
                [
                    'label'    => 'Publier',
                    'required' => false,
                    'attr'     => ['data-help' => 'Signifie que l\'album sera visible pour tout le monde'],
                ]
            )
            ->end()
            ->with('Titres')
            ->add(
                'tracks',
                ModelType::class,
                [
                    'required'     => false,
                    'expanded'     => true,
                    'multiple'     => true,
                    'by_reference' => false,
                ]
            )
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ->add('public');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->add('date')
            ->add('public');
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($album)
    {
        $urlKey = $album->getUrl();
        if (empty($urlKey)) {
            $entityUrl = new UrlDiscography();
            $entityUrl->setUrlKey($album->getTitle());

            $album->setUrl($entityUrl);
        } else {
            $urlKey->setUrlKey($album->getTitle());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function prePersist($album)
    {
        $entityUrl = new UrlDiscography();
        $entityUrl->setUrlKey($album->getTitle());

        $album->setUrl($entityUrl);
    }
}
