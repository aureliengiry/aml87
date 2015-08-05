<?php
namespace Aml\Bundle\DiscographyBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

use Aml\Bundle\UrlRewriteBundle\Entity\UrlDiscography;

class AlbumAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
            ->add(
                'title',
                'text',
                array(
                    'label' => 'Titre'
                )
            )
            ->add('image', 'sonata_type_admin')
            ->add(
                'description',
                'textarea',
                array(
                    'label' => 'Texte',
                    'attr' => array('size' => 15, 'data-help' => 'Description de l\'album'),
                    'required' => false,
                    'wysiwyg' => true
                )
            )
            ->add(
                'date',
                'sonata_type_date_picker',
                array(
                    'dp_side_by_side' => true,
                    'dp_use_current' => false,
                    'dp_language' => 'fr',
                    'format' => 'dd/MM/yyyy'
                )
            )
            ->add(
                'public',
                'checkbox',
                array(
                    'label' => 'Publier',
                    'required' => false,
                    'attr' => array('data-help' => 'Signifie que l\'album sera visible pour tout le monde'),
                )
            )
            ->end()
            ->with('Titres')
            ->add(
                'tracks',
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
     * @param string $name
     *
     * @return null|string
     */
    public function getTemplate($name)
    {
        if (isset($this->templates[$name])) {
            return $this->templates[$name];
        }

        return null;
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