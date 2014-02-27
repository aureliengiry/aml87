<?php
namespace Aml\Bundle\WebBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

use Aml\Bundle\MediasBundle\Form\Admin\ImageType;

class PartenaireAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name','text',array(
                'label' => 'Nom'
            ))
            ->add('logo','sonata_type_admin',array(
                'delete' => false,
                'required' => false
            ))
            ->add('url')
            ->add('description','textarea',array(
                'required' => false
            ))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('url')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
           ->addIdentifier('name')
           ->add('url')
        ;
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

    public function preUpdate($partenaire) {

        $this->_setLogoTitle($partenaire);
    }

    protected function _setLogoTitle($partenaire){
        $logo = $partenaire->getLogo();

        $logo->setTitle($partenaire->getName());

        // Remove old file
        $logo->storeFilenameForRemove();
        $logo->removeUpload();

        // Upload
        $logo->preUpload();
    }
}