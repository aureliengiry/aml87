<?php
namespace Aml\Bundle\BlogBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

use Aml\Bundle\MediasBundle\Form\Admin\ImageType;

class BlogAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title')
            ->add('logo',new ImageType() , array(
                'required' => false,
            ) )
            ->add('body','textarea', array(
                'label' => 'Texte',
                'attr' => array('size' => 15, 'data-help' => 'Texte de l\'article'),
                'required' => false,
            ))
            ->add('category','entity',array(
                'label' => 'Catégorie',
                'class' => 'AmlBlogBundle:BlogCategories',
                'property' => 'name',
                'empty_value' => 'Choisissez une catégorie',
            ))

            ->add('addtags', 'genemu_jqueryautocompleter_entity', array(
                'route_name' => 'blog_tags_ajax_autocomplete',
                'class' => 'Aml\Bundle\BlogBundle\Entity\BlogTags',
                'property' => 'name',
                'label' => 'Tags',
                'attr' => array(
                    'placeholder' => 'Ajouter des tags',
                ),
                'required' => false,
                'mapped' => false
            ))
            ->add('tags', 'hidden', array(
                'mapped' => false
            ))

            ->add('public','checkbox',array(
                'label' => 'Publier',
                'required' => false,
                'attr' => array('data-help' => 'Signifie que l\'article sera visible pour tout le monde'),
            ))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {

    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->add('created')
            ->add('updated')
            ->add('public')
        ;
    }

    /**
     * @param string $name
     *
     * @return null|string
     */
    public function getTemplate($name)
    {
        //var_dump( $name );
        if (isset($this->templates[$name])) {
            return $this->templates[$name];
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($article) {

        $article->setUpdated(new \DateTime);

        $this->_setLogoTitle($article);
    }

    /**
     * {@inheritdoc}
     */
    public function prePersist($article)
    {
        $article->setCreated(new \DateTime);
        $article->setUpdated(new \DateTime);

        $this->_setLogoTitle($article);
    }

    protected function _setLogoTitle($article){
        $logo = $article->getLogo();

        $logo->setTitle($article->getTitle());

        // Remove old file
        $logo->storeFilenameForRemove();
        $logo->removeUpload();

        // Upload
        $logo->preUpload();
    }
}