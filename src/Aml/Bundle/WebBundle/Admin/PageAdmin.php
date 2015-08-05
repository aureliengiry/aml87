<?php
namespace Aml\Bundle\WebBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

use Aml\Bundle\UrlRewriteBundle\Entity\UrlPage;

class PageAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add(
                'title',
                'text',
                array(
                    'label' => 'Titre'
                )
            )
            ->add(
                'body',
                'textarea',
                array(
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
                    'attr' => array('data-help' => 'Signifie que la page sera visible pour tout le monde'),
                )
            );
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ->add('url')
            ->add('public');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->add('url')
            ->add('created')
            ->add('updated')
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
    public function preUpdate($page)
    {
        $page->setUpdated(new \DateTime);

        $urlKey = $page->getUrl();
        if (empty($urlKey)) {
            $entityUrl = new UrlPage();
            $entityUrl->setUrlKey($page->getTitle());

            $page->setUrl($entityUrl);
        } else {
            $urlKey->setUrlKey($page->getTitle());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function prePersist($page)
    {
        $entityUrl = new UrlPage();
        $entityUrl->setUrlKey($page->getTitle());

        $page
            ->setCreated(new \DateTime)
            ->setUpdated(new \DateTime)
            ->setUrl($entityUrl);
    }
}