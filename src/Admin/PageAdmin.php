<?php
namespace App\Admin;

use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

use App\Entity\UrlPage;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class PageAdmin
 * @package App\Admin
 */
class PageAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add(
                'title',
                TextType::class,
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
                CheckboxType::class,
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
