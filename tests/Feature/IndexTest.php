<?php
/**
 * Created by PhpStorm.
 * User: m_sea
 * Date: 28/11/2018
 * Time: 18:28
 */

namespace Tests\Feature;


use Tests\TestCase;

class IndexTest extends TestCase
{

    public function testIndex() {
        $this->get('/')
            ->assertSee('Register')
            ->assertSee('Login')
            ->assertSee('Martin Clegg - Laravel and Vue NASA Search')
            ->assertSee('Search Nasa')
        ;
    }

}