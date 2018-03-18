<?php

namespace AppBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Controller\Admin\AbstractAdminController;

class IndexController extends AbstractAdminController
{
    /**
     * 
     * @param Request $request
     * @return Response
     */
    public function indexAction()
    {
        return $this->render('Base/admin.html.twig', [
        ]);
    }
}
