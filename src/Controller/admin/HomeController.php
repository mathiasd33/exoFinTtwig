<?php


namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    /**
     * @Route ("/admin", name="admin_home")
     */

    public function home()
    {

        return $this->render("/admin/home.html.twig");
    }
}