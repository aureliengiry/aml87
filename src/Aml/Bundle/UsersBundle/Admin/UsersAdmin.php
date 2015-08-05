<?php
namespace Aml\Bundle\UsersBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class UsersAdmin
 *
 * @package     Aml\Bundle\UsersBundle\Admin
 * @author      Aurélien GIRY <aurelien.giry@gmail.com>
 */
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
                ->add(
                    'firstname',
                    'text',
                    array(
                        'required' => false,
                    )
                )
                ->add(
                    'lastname',
                    'text',
                    array(
                        'required' => false,
                    )
                )
                ->add(
                    'enabled',
                    'checkbox',
                    array(
                        'label' => 'Actif',
                        'required' => false,
                    )
                )
            ->end()
            ->with('Management')
                ->add('enabled', null, array('required' => false))
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('email')
            ->add('username')
            ->add('enabled');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('username')
            ->add('email')
            ->add('name', 'string', array('template' => 'AmlUsersBundle::Admin/User/Fields/name.html.twig'))
            ->add('lastLogin')
            ->add('locked')
            ->add('enabled');
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
}