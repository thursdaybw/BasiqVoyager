<?php

namespace App\Application;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class ConsentService.
 *
 * This class is responsible for handling consent-related errors.
 */
class ConsentService {
  private $basiqUserService;

  /**
   * ConsentService constructor.
   *
   * @param UserService $basiqUserService
   */
  public function __construct(UserService $basiqUserService) {
    $this->basiqUserService = $basiqUserService;
  }

  /**
   * Handles consent errors and returns a response if errors are found.
   *
   * @param array $consents
   *
   * @return \Symfony\Component\HttpFoundation\Response|null
   */
  public function handleConsentErrors(array $consents): ?Response {
    if (isset($consents['data']) && !empty($consents['data'])) {
      $errors = array_filter($consents['data'], function ($item) {
          return isset($item['type']) && $item['type'] === 'error';
      });

      if (!empty($errors)) {
        error_log("Error found in the 'data' key of the response.");
        return $this->render(
          'consent_errors.html.twig',
          [
            'correleation_id' => $consents['correlationId'],
            'errors' => print_r($errors, 1),
          ]
          );
      }
    }
    return NULL;
  }

}
