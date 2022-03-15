<?php

declare(strict_types=1);

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class MenuBuilder.
 */
class MenuBuilder
{
    /**
     * Init factory.
     */
    public function __construct(private readonly FactoryInterface $factory)
    {
    }

    /**
     * Generate main menu.
     */
    public function createMainMenu(): ItemInterface
    {
        $menu = $this->factory->createItem('root');

        $menu->addChild('Accueil', ['route' => 'app_main_index']);

        $menu->addChild(
            'Association',
            [
                'route' => 'page_show_rewrite',
                'routeParameters' => ['page' => 'accordeon-autrement'],
            ]
        );

        $menu->addChild('Discographie', ['route' => 'discography']);
        $menu->addChild('Blog', ['route' => 'blog']);
        $menu->addChild('Agenda', ['route' => 'agenda']);
        $menu->addChild('Contact', ['route' => 'aml_contactus_default_index']);

        return $menu;
    }

    /**
     * Generate breadcrumb.
     */
    public function createBreadcrumbMenu(RequestStack $request): ItemInterface
    {
        $menu = $this->factory->createItem('root', [
            'childrenAttributes' => [
                'class' => 'breadcrumb',
            ],
        ]);

        // this item will always be displayed
        $menu->addChild('Accueil', ['route' => 'app_main_index']);

        // create the menu according to the route
        $currentRequest = $request->getCurrentRequest();
        $route = $currentRequest->get('_route');
        switch ($route) {
            /* ----- AGENDA ----- */
            case 'agenda':
                $menu
                    ->addChild('Agenda')
                    ->setCurrent(true);
                break;

            case 'agenda_show_event':
            case 'agenda_show_event_rewrite':
                $menu->addChild('Agenda', [
                    'route' => 'agenda',
                ]);

                $menu
                    ->addChild('label.view.post')
                    ->setCurrent(true)
                    ->setLabel($currentRequest->get('label'));
                break;
            case 'agenda_archives':
                $menu->addChild('Agenda', [
                    'route' => 'agenda',
                ]);

                $menu
                    ->addChild('label.archives.post')
                    ->setCurrent(true)
                    ->setLabel($currentRequest->get('label'));
                break;

            /* ----- Blog ----- */
            case 'blog':
                $menu
                    ->addChild('Blog')
                    ->setCurrent(true);
                break;
            case 'blog_show':
                $menu->addChild('Blog', ['route' => 'blog']);
                $menu
                    ->addChild('label.discography.show')
                    ->setCurrent(true)
                    ->setLabel($currentRequest->get('label'));
                break;

            /* ----- Page ----- */
            case 'page_show':
            case 'page_show_rewrite':
                $menu
                    ->addChild('label.page.show')
                    ->setCurrent(true)
                    ->setLabel($currentRequest->get('label'));
                break;
            /* ----- Discography ----- */
            case 'discography':
                $menu
                    ->addChild('Discographie')
                    ->setCurrent(true);
                break;
            case 'discography_album_show':
            case 'discography_album_show_rewrite':
                $menu->addChild('Discographie', ['route' => 'discography']);
                $menu
                    ->addChild('label.discography.show')
                    ->setCurrent(true)
                    ->setLabel($currentRequest->get('label'));
                break;
            /* ----- Contact us ----- */
            case 'aml_contactus_default_index':
                $menu
                    ->addChild('Contactez-nous')
                    ->setCurrent(true);
                break;
        }

        return $menu;
    }
}
