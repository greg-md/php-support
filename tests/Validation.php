<?php

namespace Greg\Support\Tests;

use Greg\Support\Validation\Validation;
use PHPUnit\Framework\TestCase;

class ValidationTest extends TestCase
{
    /**
     * @var Validation
     */
    protected $validation = null;

    public function setUp()
    {
        parent::setUp();

        $this->validation = new Validation();
    }
}