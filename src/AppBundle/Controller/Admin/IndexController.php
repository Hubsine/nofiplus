<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends Controller
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
