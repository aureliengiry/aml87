<?php

namespace Aml\Bundle\WebBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class MenuBuilder
 *
 * @package Aml\Bundle\WebBundle\Menu
 */
class MenuBuilder
{
    private $factory;

    /**
     * Init factory
     *
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Generate main menu
     *
     * @param Request $requestStack
     *
     * @return \Knp\Menu\ItemInterface
     */
    public function createMainMenu()
    {
        $menu = $this->factory->createItem('root');

        $menu->addChild('Accueil', ['route' => 'home']);

        $menu->addChild(
            'Association',
            [
                'route'           => 'page_show_rewrite',
                'routeParameters' => ['url_key' => 'accordeon-autrement']
            ]
        );

        $menu->addChild('Discographie', ['route' => 'discography']);
        $menu->addChild('Blog', ['route' => 'blog']);
        $menu->addChild('Agenda', ['route' => 'agenda']);
        $menu->addChild('Contact', ['route' => 'aml_contactus_default_index']);

        return $menu;
    }

    /**
     * Generate breadcrumb
     *
     * @param Request $request
     *
     * @return \Knp\Menu\ItemInterface
     */
    public function createBreadcrumbMenu(RequestStack $request)
    {
        $menu = $this->factory->createItem('root', [
            'childrenAttributes' => [
                'class' => 'breadcrumb',
            ]
        ]);

        // this item will always be displayed
        $menu->addChild('Accueil', ['route' => 'home']);

        // create the menu according to the route
        $currentRequest = $request->getCurrentRequest('_route');
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
                    'route' => 'agenda'
                ]);

                $menu
                    ->addChild('label.view.post')
                    ->setCurrent(true)
                    ->setLabel($currentRequest->get('label'));
                break;
            case 'agenda_archives':
                $menu->addChild('Agenda', [
                    'route' => 'agenda'
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
