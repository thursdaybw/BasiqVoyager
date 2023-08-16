<?php

namespace App\ViewModel;

use Symfony\Component\Form\FormView;

/**
 * Class HomePageViewModel.
 *
 * This class represents the view model for the home page, containing form,
 * user, accounts, errors, and message details.
 */
class HomePageViewModel {

  /**
   * The form rendered on the page, if $showForm is TRUE.
   */
  private ?FormView $form;

  /**
   * The show form flag.
   *
   * Twig templates check for this and skip form rendering.
   */
  private bool $showForm;

  /**
   * The is a user object all the way of BasiqApi converted to an object.
   *
   * I should resolve that. I am thinking of enabling strict typing.
   */
  private \StdClass $user;

  /**
   * The accounts.
   */
  private array $accounts;

  /**
   * Any errors we pulled to display below the form, for debugging.
   */
  private array $errors;

  /**
   * This message displays in the messages block.
   */
  private string $message;

  /**
   * Gets the form view.
   *
   * @return ?FormView
   */
  public function getForm(): ?FormView {
    return $this->form;
  }

  /**
   * Sets the form view.
   *
   * @param ?FormView $form
   */
  public function setForm(?FormView $form): void {
    $this->form = $form;
  }

  /**
   * Gets the show form flag.
   *
   * @return bool
   */
  public function getShowForm(): bool {
    return $this->showForm;
  }

  /**
   * Sets the show form flag.
   *
   * @param bool $showForm
   */
  public function setShowForm(bool $showForm): void {
    $this->showForm = $showForm;
  }

  /**
   * Gets the user details.
   */
  public function getUser(): ?\StdClass {
    return $this->user ?? NULL;
  }

  /**
   * Sets the user details.
   *
   * @param \StdClass $user
   */
  public function setUser(\StdClass $user): void {
    $this->user = $user;
  }

  /**
   * Gets the accounts details.
   *
   * @return ?\OpenAPI\Client\Model\Account[]
   */
  public function getAccounts(): ?array {
    return $this->accounts ?? NULL;
  }

  /**
   * Sets the accounts details.
   *
   * @param array $accounts
   */
  public function setAccounts(array $accounts): void {
    $this->accounts = $accounts;
  }

  /**
   * Gets the errors details.
   */
  public function getErrors(): ?array {
    return $this->errors ?? NULL;
  }

  /**
   * Sets the errors details.
   *
   * @param array $errors
   */
  public function setErrors(array $errors): void {
    $this->errors = $errors;
  }

  /**
   * Gets the message details.
   */
  public function getMessage(): ?string {
    return $this->message ?? NULL;
  }

  /**
   * Sets the message details.
   *
   * @param string $message
   */
  public function setMessage(string $message): void {
    $this->message = $message;
  }

}
