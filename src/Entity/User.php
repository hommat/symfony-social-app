<?php

namespace App\Entity;

use DateTime;
use Symfony\Component\Validator\Constraints as Assert;

class User
{
  /**
   * @Assert\NotBlank
   * @Assert\Length(min = 3, max = 20)
   */
  private $username;

  /**
   * @Assert\NotBlank
   * @Assert\Email
   */
  private $email;

  /**
   * @Assert\NotBlank
   * @Assert\Length(min = 3, max = 20)
   */
  private $password;

  /**
   * @Assert\NotBlank
   * @Assert\Length(min = 3, max = 20)
   */
  private $firstName;

  /**
   * @Assert\NotBlank
   * @Assert\Length(min = 3, max = 20)
   */
  private $lastName;

  /**
   * @Assert\NotBlank
   * @Assert\Type("\DateTime")
   */
  private $birthDate;

  public function __construct()
  {
    $this->birthDate = new DateTime();
  }

  public function getUsername(): string
  {
    return $this->username;
  }

  public function getEmail(): string
  {
    return $this->email;
  }

  public function getPassword(): string
  {
    return $this->password;
  }

  public function getFirstName(): string
  {
    return $this->firstName;
  }

  public function getLastName(): string
  {
    return $this->lastName;
  }

  public function getBirthDate(): \DateTime
  {
    return $this->birthDate;
  }

  public function setUsername(string $username)
  {
    $this->username = $username;
  }

  public function setEmail(string $email)
  {
    $this->email = $email;
  }

  public function setPassword(string $password)
  {
    $this->password = $password;
  }

  public function setFirstName(string $firstName)
  {
    $this->firstName = $firstName;
  }

  public function setLastName(string $lastName)
  {
    $this->lastName = $lastName;
  }

  public function setBirthDate(\DateTime $birthDate)
  {
    $this->birthDate = $birthDate;
  }
}
