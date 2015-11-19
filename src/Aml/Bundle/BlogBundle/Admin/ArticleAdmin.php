<?php
namespace Aml\Bundle\BlogBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

use Aml\Bundle\UrlRewriteBundle\Entity\UrlArticle;

/**
 * Class ArticleAdmin
 *
 * @package     Aml\Bundle\BlogBundle\Admin
 * @author      Aurélien GIRY <aurelien.giry@gmail.com>
 */
class ArticleAdmin extends Admin
{
    // setup the default sort column and order
    protected $datagridValues = array(
        '_sort_order' => 'DESC',
        '_sort_by' => 'id'
    );

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
            ->add('title', 'text')
            ->add(
                'category',
                'entity',
                array(
                    'label' => 'Catégorie',
                    'class' => 'AmlBlogBundle:Category',
                    'property' => 'name',
                    'empty_value' => 'Choisissez une catégorie',
                    'attr' => array('class' => 'uniform')
                )
            )
            ->add(
                'body',
                'textarea',
                array(
                    'label' => 'Texte',
                    'attr' => array('size' => 15, 'data-help' => 'Texte de l\'article'),
                    'required' => false,
                    'wysiwyg' => true
                )
            )
            ->add(
                'public',
                'checkbox',
                array(
                    'label' => 'Publier',
                    'required' => false,
                    'attr' => array('data-help' => 'Signifie que l\'article sera visible pour tout le monde'),
                )
            )
            ->end()
            ->with('Image')
            ->add(
                'logo',
                'sonata_type_admin',
                array(
                    'delete' => false,
                    'required' => false
                )

            )
            ->end()
            ->with('Tags')
            ->add(
                'tags',
                'sonata_type_model',
                array(
                    'required' => false,
                    'expanded' => false,
                    'multiple' => true,
                    'by_reference' => false,
                    'attr' => array('data-sonata-select2' => 'true')
                )
            )
            ->end()
            ->with('Evenements')
            ->add(
                'evenements',
                'sonata_type_model',
                array(
                    'required' => false,
                    'expanded' => true,
                    'multiple' => true,
                    'by_reference' => false,

                )
            )
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ->add('category')
            ->add('public');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->add('created')
            ->add('updated')
            ->add('category')
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
    public function preUpdate($article)
    {
        $article->setUpdated(new \DateTime);

        $urlKey = $article->getUrl();
        if (empty($urlKey)) {
            $entityUrl = new UrlArticle();
            $entityUrl->setUrlKey($article->getTitle());

            $article->setUrl($entityUrl);
        } else {
            $urlKey->setUrlKey($article->getTitle());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function prePersist($article)
    {
        $entityUrl = new UrlArticle();
        $entityUrl->setUrlKey($article->getTitle());

        $article
            ->setCreated(new \DateTime)
            ->setUpdated(new \DateTime)
            ->setUrl($entityUrl);
    }
}
