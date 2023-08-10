<?php

namespace App\Service;

/**
 *
 */
class ConsentService {
  private $basiqUserService;

  /**
   *
   */
  public function __construct(BasiqUserService $basiqUserService) {
    $this->basiqUserService = $basiqUserService;
  }

  /**
   *
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
