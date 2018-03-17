<?php

namespace AppBundle\Controller\Admin\Category;

use AppBundle\Controller\Admin\AbstractAdminController;
use AppBundle\Entity\Admin\Category\Compagny;
use AppBundle\Form\Type\Admin\Category\CompagnyType;

class CompagnyController extends AbstractAdminController
{
    const BASE_ROUTE    = Compagny::ROUTE_PREFIX . '_index';
    const ENTITY        = Compagny::class;
    const TYPE          = CompagnyType::class;
    const FOLDER        = 'Category\Compagny';
}
