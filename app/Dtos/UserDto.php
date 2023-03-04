<?php

namespace App\Dtos;

class UserDto
{
    public function __construct(
        protected string $email,
        protected string $password,
        protected ?string $name = null,
        protected ?string $emailVerifiedAt = null,
        protected ?string $rememberToken = null,
    ) {
    }

    /**
     * @return ?string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return ?string
     */
    public function getEmailVerifiedAt(): ?string
    {
        return $this->emailVerifiedAt;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}
