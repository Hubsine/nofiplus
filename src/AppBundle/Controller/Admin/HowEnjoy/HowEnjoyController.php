<?php

namespace AppBundle\Controller\Admin\HowEnjoy;

use AppBundle\Controller\Admin\Controller;
use AppBundle\Entity\Admin\HowEnjoy\HowEnjoy;
use AppBundle\Form\Type\Admin\HowEnjoy\HowEnjoyType;

class HowEnjoyController extends Controller
{
    const BASE_ROUTE    = HowEnjoy::ROUTE_PREFIX . '_index';
    const ENTITY        = HowEnjoy::class;
    const TYPE          = HowEnjoyType::class;
    const FOLDER        = 'HowEnjoy';
}
