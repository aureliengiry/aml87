<?php
namespace Aml\Bundle\AdminBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class WysiwygTypeExtension extends AbstractTypeExtension
{
    /**
     * Returns the name of the type being extended.
     *
     * @return string The name of the type being extended
     */
    public function getExtendedType()
    {
        return 'textarea';
    }

    /**
     * Add the wysiwyg option
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setOptional(array('wysiwyg'));
    }

    /**
     * Pass the image URL to the view
     *
     * @param FormView $view
     * @param FormInterface $form
     * @param array $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if ( !array_key_exists('wysiwyg', $options) ) {
            $parentData = $form->getParent()->getData();

            // set an "wysiwyg" variable that will be available when rendering this field
            $view->vars['wysiwyg'] = false;
        }
        else{
            $view->vars['wysiwyg'] = $options['wysiwyg'];
        }
    }
}