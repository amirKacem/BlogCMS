<?php

namespace App\Controller\Admin;

use App\Entity\Menu;
use App\Repository\MenuRepository;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\RequestStack;

class MenuCrudController extends AbstractCrudController
{
    const MENU_PAGES = 0;
    const MENU_ARTICLES = 1;
    const MENU_LINKS = 2;
    const MENU_CATEGORIES = 3;

    public function __construct(private RequestStack $requestStack,private MenuRepository $menuRepository){
    }
    public static function getEntityFqcn(): string
    {
        return Menu::class;
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $subMenuIndex = $this->getSubMenuIndex();
        return $this->menuRepository->getIndexQueryBuilder($this->getFieldNameFromSubMenuIndex($subMenuIndex));
    }

    public function configureCrud(Crud $crud): Crud
    {
        $subMenuIndex = $this->getSubMenuIndex();
        $entityLabelInSingular = 'un menu';
        $entityLabelInPlural = match ($subMenuIndex){
          self::MENU_ARTICLES => 'Articles',
          self::MENU_CATEGORIES => 'Categories',
          self::MENU_LINKS => 'Liens personnalises',
          default => 'Pages',
        };
        return $crud
                ->setEntityLabelInSingular($entityLabelInSingular)
                ->setEntityLabelInPlural($entityLabelInPlural);
    }



    public function configureFields(string $pageName): iterable
    {
        $subMenuIndex = $this->getSubMenuIndex();
        return [
            TextField::new('name','Titre de la navigation'),
            NumberField::new('menuOrder','Order'),
            $this->getFieldFromSubMenuIndex($subMenuIndex)->setRequired(true),
            BooleanField::new('isVisible','Visible'),
            AssociationField::new('subMenus','Sous-éLéments'),
        ];
    }


    private function getSubMenuIndex(): Int
    {
        return $this->requestStack->getMainRequest()->query->getInt('submenuIndex');
    }

    private function getFieldNameFromSubMenuIndex(int $subMenuIndex)
    {
        return match ($subMenuIndex){
            self::MENU_ARTICLES => 'article',
            self::MENU_CATEGORIES => 'category',
            self::MENU_LINKS => 'link',
            default => 'page'
        };

    }

    private function getFieldFromSubMenuIndex(int $subMenuIndex): AssociationField|TextField
    {
        $fieldName = $this->getFieldNameFromSubMenuIndex($subMenuIndex);
        return ($fieldName === 'link') ?  TextField::new($fieldName,'Lien') : AssociationField::new($fieldName);
    }
}
