<?php
namespace Aml\Bundle\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class PartenaireAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add(
                'name',
                'text',
                array(
                    'label' => 'Nom'
                )
            )
            ->add(
                'logo',
                'sonata_type_admin',
                array(
                    'delete' => false,
                    'required' => false
                )
            )
            ->add('url')
            ->add(
                'description',
                'textarea',
                array(
                    'required' => false
                )
            );
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('url');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('url');
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

    public function preUpdate($partenaire)
    {
        $this->setLogoTitle($partenaire);
    }

    protected function setLogoTitle($partenaire)
    {
        $logo = $partenaire->getLogo();

        $logo->setTitle($partenaire->getName());

        // Remove old file
        $logo->storeFilenameForRemove();
        $logo->removeUpload();

        // Upload
        $logo->preUpload();
    }
}