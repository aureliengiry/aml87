<?php
namespace Aml\Bundle\UsersBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class UsersAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('email','email',array(
                'label' => 'Adresse Email'
            ))
            ->add('username')
            ->add('password','password')
          //  ->add('civilite')
            //->add('nom')
            //->add('prenom')
            //->add('adresse')
           // ->add('avatar')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('email')
            ->add('username')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('username')
            ->addIdentifier('email')
           //->add('last_login')
            //->add('statut')
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
}