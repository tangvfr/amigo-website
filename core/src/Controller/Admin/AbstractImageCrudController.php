<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

abstract class AbstractImageCrudController extends AbstractCrudController
{
    protected const TYPE_IMAGE = 'image/png,image/gif,image/jpeg,image/webp';
    protected const HELP_IMAGE = 'jpeg, png, gif de 5Mo';
    protected const BASE_PATH = 'uploads/';
    protected const UPLOAD_DIR = 'public/uploads/';

    public function supprImage(array $images): void
    {
        // Supprime les images physiques du système de fichiers
        foreach ($images as $image) {
            if ($image != null) {
                $uploadDir = self::UPLOAD_DIR;
                $baseDir = $this->getParameter('kernel.project_dir');
                $filePath = "{$baseDir}/{$uploadDir}{$image}";
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }
    }
}