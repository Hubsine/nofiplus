<?php

namespace AppBundle\Controller\Admin\Category;

use AppBundle\Controller\Admin\AbstractAdminController;
use AppBundle\Entity\Admin\Category\Carte;
use AppBundle\Form\Type\Admin\Category\CarteType;

class CarteController extends AbstractAdminController
{
    const BASE_ROUTE    = Carte::ROUTE_PREFIX . '_index';
    const ENTITY        = Carte::class;
    const TYPE          = CarteType::class;
    const FOLDER        = 'Category\Carte';
}
