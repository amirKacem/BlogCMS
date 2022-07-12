<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Menu;
use App\Entity\Page;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{

    public function __construct(
        private AdminUrlGenerator $adminUrlGenerator
    )
    {
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {

        $url = $this->adminUrlGenerator->setController(ArticleCrudController::class)->generateUrl();
        return $this->redirect($url);

    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Symfony CMS');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::LinkToRoute('Aller sur le site', 'fa fa-undo','home');
        yield MenuItem::subMenu('Articles', 'fas fa-newspaper')->setSubItems([

            MenuItem::linkToCrud('Tous les articles','fas fa-newspaper',Article::class),
            MenuItem::linkToCrud('Ajouter','fas fa-plus',Article::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Catégories','fas fa-list',Category::class),

        ]);
        yield MenuItem::linkToCrud('Commentaires', 'fas fa-comment', Comment::class);

        yield MenuItem::subMenu('Menus', 'fas fa-list')->setSubItems([

            MenuItem::linkToCrud('Pages', 'fas fa-file', Menu::class),
            MenuItem::linkToCrud('Articles', 'fas fa-newspaper', Menu::class),
            MenuItem::linkToCrud('Liens personnalisés', 'fas fa-link', Menu::class),
            MenuItem::linkToCrud('Categories', 'fas fa-delicious', Menu::class),

        ]);
    }
}
