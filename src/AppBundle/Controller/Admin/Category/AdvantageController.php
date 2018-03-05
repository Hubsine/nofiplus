<?php

namespace AppBundle\Controller\Admin\Category;

use AppBundle\Controller\Admin\Controller;
use AppBundle\Entity\Admin\Category\Advantage;
use AppBundle\Form\Type\Admin\Category\AdvantageType;

class AdvantageController extends Controller
{
    const BASE_ROUTE    = Advantage::ROUTE_PREFIX . '_index';
    const ENTITY        = Advantage::class;
    const TYPE          = AdvantageType::class;
    const FOLDER        = 'Category\Advantage';
}
