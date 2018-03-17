<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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
    public function indexAction(Request $request)
    {
        return $this->render('Base/admin.html.twig', [
        ]);
    }
}
