<?php

namespace App\Controller\Admin;

use App\Entity\Media;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MediaCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Media::class;
    }


    public function configureFields(string $pageName): iterable
    {
        $media_dir = $this->getParameter('media_directory');
        $uploads_dir = $this->getParameter('uploads_directory');
        $imageField = ImageField::new('filename','Média')
                        ->setBasePath($uploads_dir)
                        ->setUploadDir($media_dir)
                        ->setUploadedFileNamePattern('[slug]-[uuid].[extension]');
        if(Crud::PAGE_EDIT == $pageName){
            $imageField->setRequired(false);
        }
        return [
            TextField::new('name'),
            TextField::new('altText','Texte alternatif'),
            $imageField,
        ];
    }

}
