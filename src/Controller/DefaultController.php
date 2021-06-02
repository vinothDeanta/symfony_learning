<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


class DefaultController extends AbstractController
{
    /**
     * @Route("/index/{max}", name="index")
    */
    public function index(int $max)
    {
        $number = random_int(0, $max);

        return new JsonResponse([
            'action' => $number,
            'time'=>time()
        ]);
    }
}

?>