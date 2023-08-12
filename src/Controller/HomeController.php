<?php

namespace App\Controller;

use App\Application\HomePageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Home Page Controller.
 *
 * The HomeController class serves as the entry point for requests directed to
 * the home page of the application. It extends Symfony's AbstractController,
 * inheriting common functionality for handling HTTP requests and rendering
 * views.
 *
 * The renderHomePage method within this class is specifically responsible for
 * handling requests to the root URL ('/'). Upon receiving a request, it
 * delegates the processing to the HomePageService, which encapsulates the
 * business logic and data retrieval necessary for the home page. The result,
 * encapsulated within a view model, is then passed to the Twig template
 * 'home/index.html.twig' for rendering.
 *
 * The use of a dedicated service class (HomePageService) and a view model
 * allows for a clean separation of concerns, ensuring that the controller
 * remains focused on coordinating the request handling, while the service
 * class handles the underlying business logic, and the view model facilitates
 * the presentationBankingDataApi/BankingDataApiInterface.php.
 *
 * This design promotes maintainability, testability, and adherence to the
 * principles of clean code.
 */
class HomeController extends AbstractController {

  private $homePageService;

  /**
   * Constructs a new HomeController.
   */
  public function __construct(HomePageService $homePageService) {
    $this->homePageService = $homePageService;
  }

  /**
   * Renders the home page.
   *
   * Handles the request for the home page, delegates processing to the
   * HomePageService, and returns the rendered view.
   */
  #[Route('/', name: 'home')]
  public function renderHomePage(Request $request): Response {
    $viewModel = $this->homePageService->handleHomePageRequest($request);

    return $this->render('home/index.html.twig', [
      'viewModel' => $viewModel,
    ]);
  }

}
