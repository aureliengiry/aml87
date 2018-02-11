<?php
namespace Aml\Bundle\AdminBundle\Admin;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

use Aml\Bundle\AdminBundle\Entity\UrlPage;

class PageAdmin extends AbstractAdmin
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
                CKEditorType::class,
                array(
                    'required' => false,
                    'config_name' => 'aml_config',
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