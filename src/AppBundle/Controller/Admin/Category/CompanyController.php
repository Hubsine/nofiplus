<?php

namespace AppBundle\Controller\Admin\Category;

use AppBundle\Controller\Admin\AbstractAdminController;
use AppBundle\Entity\Admin\Category\Company;
use AppBundle\Form\Type\Admin\Category\CompanyType;

class CompanyController extends AbstractAdminController
{
    const BASE_ROUTE    = Company::ROUTE_PREFIX . '_index';
    const ENTITY        = Company::class;
    const TYPE          = CompanyType::class;
    const FOLDER        = 'Category\Company';
}
