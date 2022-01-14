<?php

namespace Alura\Calisthenics\Domain\Student;


class FullName
{
    private string $lastName;
    private string $firstName;

    public function __construct(string $firstName, string $lastName)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function __toString()
    {
        return "{$this->firstName} {$this->lastName}";
    }
}