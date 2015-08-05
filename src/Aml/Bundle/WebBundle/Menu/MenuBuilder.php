<?php
namespace Aml\Bundle\WebBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class MenuBuilder
{
    private $factory;

    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function createMainMenu(Request $requestStack)
    {
        $menu = $this->factory->createItem('root');

        $menu->addChild('Accueil', array('route' => 'home'));

        $menu->addChild(
            'Association',
            array(
                'route' => 'page_show_rewrite',
                'routeParameters' => array('url_key' => 'laccordon-autrement')
            )
        );

        $menu->addChild('Discographie', array('route' => 'discography'));
        $menu->addChild('Blog', array('route' => 'blog'));
        $menu->addChild('Agenda', array('route' => 'agenda'));
        $menu->addChild('Contact', array('route' => 'aml_contact_us_index'));

        return $menu;
    }

    public function createBreadcrumbMenu(Request $request)
    {
        $menu = $this->factory->createItem(
            'root',
            array(
                'childrenAttributes' => array(
                    'class' => 'breadcrumb',
                )
            )
        );
        // this item will always be displayed
        $menu->addChild('Accueil', array('route' => 'home'));

        // create the menu according to the route
        switch ($request->get('_route')) {
            /* ----- AGENDA ----- */
            case 'agenda':
                $menu
                    ->addChild('Agenda')
                    ->setCurrent(true);
                break;

            case 'agenda_show_event':
            case 'agenda_show_event_rewrite':
                $menu->addChild(
                    'Agenda',
                    array(
                        'route' => 'agenda'
                    )
                );

                $menu
                    ->addChild('label.view.post')
                    ->setCurrent(true)
                    ->setLabel($request->get('label'));
                break;

            /* ----- Blog ----- */
            case 'blog':
                $menu
                    ->addChild('Blog')
                    ->setCurrent(true);
                break;
            case 'blog_show':
            case 'blog_show_rewrite':
                $menu->addChild('Blog', array('route' => 'blog'));
                $menu
                    ->addChild('label.discography.show')
                    ->setCurrent(true)
                    ->setLabel($request->get('label'));
                break;

            /* ----- Page ----- */
            case 'page_show':
            case 'page_show_rewrite':
                $menu
                    ->addChild('label.page.show')
                    ->setCurrent(true)
                    ->setLabel($request->get('label'));
                break;
            /* ----- Discography ----- */
            case 'discography':
                $menu
                    ->addChild('Discographie')
                    ->setCurrent(true);
                break;
            case 'discography_album_show':
            case 'discography_album_show_rewrite':
                $menu->addChild('Discographie', array('route' => 'discography'));
                $menu
                    ->addChild('label.discography.show')
                    ->setCurrent(true)
                    ->setLabel($request->get('label'));
                break;
            /* ----- Contact us ----- */
            case 'aml_contact_us_index':
                $menu
                    ->addChild('Contactez-nous  ')
                    ->setCurrent(true);
                break;
        }

        return $menu;
    }
}