<?php

namespace Alura\Calisthenics\Domain\Student;

class Endereco
{
    public string $street;
    public string $number;
    public string $province;
    public string $city;
    public string $state;
    public string $country;

    public function __construct($street, $number, $province, $city, $state, $country)
    {
        $this->street = $street;
        $this->number = $number;
        $this->province = $province;
        $this->city = $city;
        $this->state = $state;
        $this->country = $country;
    }
}