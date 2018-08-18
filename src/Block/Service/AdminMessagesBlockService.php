<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Block\Service;

use App\Entity\Message;
use Doctrine\Common\Persistence\ObjectManager;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\Service\AbstractBlockService;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AdminMessagesBlockService.
 */
class AdminMessagesBlockService extends AbstractBlockService
{
    /**
     * @var ObjectManager
     */
    protected $em;

    /**
     * AdminMessagesBlockService constructor.
     *
     * @param string $name
     */
    public function __construct($name, EngineInterface $templating, ObjectManager $em)
    {
        parent::__construct($name, $templating);

        $this->em = $em;
    }

    /**
     * {@inheritdoc}
     */
    public function configureSettings(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'title' => 'Messages du formulaire de contact',
            'template' => 'Block/block_messages.html.twig',
        ]);
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
                'block' => $blockContext->getBlock(),
                'settings' => $settings,
                'messages' => $messages,
            ],
            $response
        );
    }
}
