<?php

namespace App\Controller;

use App\Service\HomePageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $homePageService;

    public function __construct(HomePageService $homePageService)
    {
        $this->homePageService = $homePageService;
    }

    #[Route('/', name: 'home')]
    public function index(Request $request): Response
    {
        $viewModel = $this->homePageService->handleHomePageRequest($request);
        return $this->render('home/index.html.twig', [
            'viewModel' => $viewModel
        ]);
    }
}
