<?php

namespace Tests\Unit;

use App\Facades\Validate;
use Tests\TestCase;

class ValidateTest extends TestCase
{
    /** @test */
    public function validate_currency_passes()
    {
        $validate = Validate::currency('EUR');
        $this->assertEquals([], $validate->getErrors());
    }

    /** @test */
    public function validate_currency_fails()
    {
        $validate = Validate::currency('ABC');

        $this->assertArrayHasKey('errors', $validate->getErrors());
    }

    /** @test */
    public function validate_date_passes()
    {
        $validate = Validate::date('2021-02-10');

        $this->assertEquals([], $validate->getErrors());
    }

    /** @test */
    public function date_must_be_yyyy_mm_dd_format()
    {
        $validate = Validate::date('10-02-2021');
        $this->assertArrayHasKey('date', $validate->getErrors()['errors']);
    }

    /** @test */
    public function date_must_be_existing()
    {
        $validate = Validate::date('2021-02-30');
        $this->assertArrayHasKey('date', $validate->getErrors()['errors']);
    }

    /** @test */
    public function validation_symbols_passes()
    {
        $validate = Validate::symbols('EUR');
        $this->assertEquals([], $validate->getErrors());
    }

    /** @test */
    public function validation_symbols_fails()
    {
        $validate = Validate::symbols('ABC');
        $this->assertArrayHasKey('ABC', $validate->getErrors()['errors']);

    }
}
