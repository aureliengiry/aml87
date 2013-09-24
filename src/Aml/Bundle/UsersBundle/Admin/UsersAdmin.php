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
            ->with('General')
                ->add('username')
                ->add('email')
                ->add('plainPassword', 'text', array('required' => false))
            ->end()
            ->with('Profile')
          //  ->add('civilite')
                ->add('firstname','text', array(
                    'required' => false,
                ))
                ->add('lastname','text', array(
                    'required' => false,
                ))
                ->add('enabled','checkbox', array(
                    'label'=> 'Actif',
                    'required' => false,
                ))
            ->end()

         //if ($this->getSubject() && !$this->getSubject()->hasRole('ROLE_SUPER_ADMIN')) {
             //$formMapper
                 ->with('Management')
                 /*->add('realRoles', 'sonata_security_roles', array(
                     'expanded' => true,
                     'multiple' => true,
                     'required' => false
                 ))*/
               //  ->add('locked', null, array('required' => false))
               //  ->add('expired', null, array('required' => false))
                 ->add('enabled', null, array('required' => false))
               //  ->add('credentialsExpired', null, array('required' => false))
                 ->end()
            // ;
         //}
            //->add('adresse')
           // ->add('avatar')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('email')
            ->add('username')
            ->add('enabled')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('username')
            ->add('email')
            ->add(array('firstname','lastname'))
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