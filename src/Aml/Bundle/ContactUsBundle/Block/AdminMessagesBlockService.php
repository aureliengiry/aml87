<?php
/**
 * Andromeda
 *
 * NOTICE OF LICENSE
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Andromeda to newer
 * versions in the future.
 *
 * @category    Andromeda
 * @package     Andromeda_${NAME}
 * @copyright   Copyright (c) 2011-2015 Brady. (http://www.brady.com)
 */

namespace Aml\Bundle\ContactUsBundle\Block;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\BlockBundle\Block\BlockContextInterface;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Sonata\BlockBundle\Block\BaseBlockService;

use Doctrine\ORM\EntityManager;

class AdminMessagesBlockService extends BaseBlockService
{

    /**
     * @var Security
     */
    protected $security;

    /**
     * @var Pool
     */
    protected $pool;

    /**
     * @var EntityManager
     */
    protected $em;

    public function __construct($name, $templating, EntityManager $em)
    {
        parent::__construct($name, $templating);

        $this->em = $em;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'title' => 'Messages du formulaire de contact',
                'template' => 'AmlContactUsBundle:Block:messagesListDashboard.html.twig'
            )
        );
    }

    public function getDefaultSettings()
    {
        return array();
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Messages';
    }

    /**
     * {@inheritdoc}
     */
    public function validateBlock(ErrorElement $errorElement, BlockInterface $block)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function buildEditForm(FormMapper $formMapper, BlockInterface $block)
    {

    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        // merge settings
        $settings = $blockContext->getSettings();

        $messages = $this->em->getRepository('AmlContactUsBundle:Message')->findBy(
            array(),
            array('created' => 'DESC'),
            5
        );

        return $this->renderResponse(
            $blockContext->getTemplate(),
            array(
                'block' => $blockContext->getBlock(),
                'settings' => $settings,
                'messages' => $messages
            ),
            $response
        );
    }
}