<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Evenement;
use App\Entity\Image;
use App\Entity\Message;
use App\Entity\Page;
use App\Entity\User;
use App\Entity\Video\Youtube;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class DashboardController extends AbstractDashboardController
{
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('AML87')
            ->setTranslationDomain('admin')
//            ->setTextDirection('ltr')
            ->renderContentMaximized()
//            ->renderSidebarMinimized()
;
    }

    public function configureCrud(): Crud
    {
        return Crud::new();
    }

    public function configureMenuItems(): iterable
    {
        $submenu1 = [
            MenuItem::linkToCrud('Blog', 'far fa-newspaper', Article::class),
            MenuItem::linkToCrud('Pages', 'fas fa-edit', Page::class),
            MenuItem::linkToCrud('Agenda', 'fas fa-calendar-alt', Evenement::class),
        ];

        $submenu2 = [
            MenuItem::linkToCrud('Images', 'far fa-picture', Image::class),
            MenuItem::linkToCrud('Vidéos', 'far fa-video', Youtube::class),
        ];

        $submenu3 = [
            MenuItem::linkToCrud('Membres', 'fas fa-user', User::class)->setDefaultSort(['lastLogin' => 'DESC']),
            MenuItem::linkToCrud('Messages', 'fas fa-envelope', Message::class)->setDefaultSort(['created' => 'DESC']),
        ];

        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::subMenu('Contenus', 'fas fa-folder-open')->setSubItems($submenu1);
        yield MenuItem::subMenu('Médias', 'fas fa-folder-open')->setSubItems($submenu2);
        yield MenuItem::subMenu('Administration', 'fas fa-cogs')->setSubItems($submenu3);
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        // Usually it's better to call the parent method because that gives you a
        // user menu with some menu items already created ("sign out", "exit impersonation", etc.)
        // if you prefer to create the user menu from scratch, use: return UserMenu::new()->...
        return parent::configureUserMenu($user)
            // use the given $user object to get the user name
            ->setName($user->getFullName())
            // use this method if you don't want to display the name of the user
//            ->displayUserName(false)

            // you can return an URL with the avatar image
//            ->setAvatarUrl('https://...')
//            ->setAvatarUrl($user->getProfileImageUrl())
            // use this method if you don't want to display the user image
            ->displayUserAvatar(false)
            // you can also pass an email address to use gravatar's service
//            ->setGravatarEmail($user->getMainEmailAddress())

            // you can use any type of menu item, except submenus
            ->addMenuItems([
                MenuItem::linkToRoute('My Profile', 'fa fa-id-card', '...', ['...' => '...']),
                MenuItem::linkToRoute('Settings', 'fa fa-user-cog', '...', ['...' => '...']),
                MenuItem::section(),
                MenuItem::linkToLogout('Logout', 'fa fa-sign-out'),
            ]);
    }

    /**
     * @Route("/admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

//    public function index(): Response
//    {
//        // redirect to some CRUD controller
//        $routeBuilder = $this->get(AdminUrlGenerator::class);
//
//        return $this->redirect($routeBuilder->setController(OneOfYourCrudController::class)->generateUrl());
//
//        // you can also redirect to different pages depending on the current user
//        if ('jane' === $this->getUser()->getUsername()) {
//            return $this->redirect('...');
//        }
//
//        // you can also render some template to display a proper Dashboard
//        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
//        return $this->render('some/path/my-dashboard.html.twig');
//    }
}
