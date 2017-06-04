<?php

namespace Aml\Bundle\ContactUsBundle\Block\Service;

use Aml\Bundle\ContactUsBundle\Entity\Message;
use Sonata\BlockBundle\Block\Service\AbstractBlockService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\BlockBundle\Block\BlockContextInterface;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Validator\ErrorElement;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

use Doctrine\ORM\EntityManager;

/**
 * Class AdminMessagesBlockService
 * @package Aml\Bundle\ContactUsBundle\Block\Service
 */
class AdminMessagesBlockService extends AbstractBlockService
{
    /**
     * @var Pool
     */
    protected $pool;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * AdminMessagesBlockService constructor.
     *
     * @param string $name
     * @param EngineInterface $templating
     * @param EntityManager $em
     */
    public function __construct($name, EngineInterface $templating, EntityManager $em)
    {
        parent::__construct($name, $templating);

        $this->em = $em;
    }

    /**
     * {@inheritdoc}
     */
    public function configureSettings(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'title'    => 'Messages du formulaire de contact',
                'template' => 'AmlContactUsBundle:Block:block_messages.html.twig',
            )
        );
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

        $messages = $this->em->getRepository(Message::class)->findBy(
            ['spam' => 0],
            ['created' => 'DESC'],
            5
        );

        return $this->renderResponse(
            $blockContext->getTemplate(),
            [
                'block'    => $blockContext->getBlock(),
                'settings' => $settings,
                'messages' => $messages,
            ],
            $response
        );
    }
}
