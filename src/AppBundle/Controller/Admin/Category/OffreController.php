<?php

namespace AppBundle\Controller\Admin\Category;

use AppBundle\Controller\Admin\Controller;
use AppBundle\Entity\Admin\Category\Offre;
use AppBundle\Form\Type\Admin\Category\OffreType;

class OffreController extends Controller
{
    const BASE_ROUTE    = Offre::ROUTE_PREFIX . '_index';
    const ENTITY        = Offre::class;
    const TYPE          = OffreType::class;
    const FOLDER        = 'Category\Offre';
}
