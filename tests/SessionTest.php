<?php

namespace Greg\Support\Tests;

use Greg\Support\Session;
use PHPUnit\Framework\TestCase;

/**
 * Class SessionTest.
 *
 * @runTestsInSeparateProcesses
 */
class SessionTest extends TestCase
{
    use TestingAccessorTrait;

    public function testingAccessorSetup()
    {
        session_start();
    }

    protected function staticObject()
    {
        return Session::class;
    }

    protected function &staticAccessor()
    {
        return $_SESSION;
    }

    /** @test */
    public function it_reloads_flash_data()
    {
        $_SESSION['__FLASH__'] = ['foo' => 'bar'];

        $this->assertEquals(['foo' => 'bar'], Session::reloadFlash());

        $this->assertArrayNotHasKey('__FLASH__', $_SESSION);
    }

    /** @test */
    public function it_loads_flash_data()
    {
        $_SESSION['__FLASH__'] = ['foo' => 'bar'];

        $this->assertEquals(['foo' => 'bar'], Session::loadFlash());

        $this->assertArrayNotHasKey('__FLASH__', $_SESSION);

        $this->assertEquals(['foo' => 'bar'], Session::loadFlash());
    }

    /** @test */
    public function it_sets_flash_data()
    {
        Session::setFlash('foo', 'bar');

        Session::setFlash(['a' => 1]);

        $this->assertEquals(['foo' => 'bar', 'a' => 1], $_SESSION['__FLASH__']);

        $this->assertEquals(['foo' => 'bar', 'a' => 1], Session::getFlash());
    }

    /** @test */
    public function it_gets_flash_data()
    {
        $_SESSION['__FLASH__'] = ['foo' => 'bar'];

        $this->assertEquals('bar', Session::getFlash('foo'));
    }

    /** @test */
    public function it_unloads_flash_data()
    {
        $_SESSION['__FLASH__'] = ['foo' => 'bar'];

        Session::loadFlash();

        Session::unloadFlash();

        $this->assertEquals([], Session::getFlash());
    }

    /** @test */
    public function it_checks_ini_configs()
    {
        Session::setIni('cookie_lifetime', 80);

        $this->assertEquals(80, ini_get('session.cookie_lifetime'));

        $this->assertEquals(80, Session::getIni('cookie_lifetime'));
    }

    /** @test */
    public function it_checks_id()
    {
        $this->assertFalse(Session::hasId());

        $id = Session::getId();

        $this->assertEquals(session_id(), $id);

        $this->assertTrue(Session::hasId());

        $this->assertEquals($id, Session::setId('phpunit'));

        $this->assertEquals('phpunit', Session::getId());
    }

    /** @test */
    public function it_checks_persistent()
    {
        $this->assertFalse(Session::persistent());

        $this->assertTrue(Session::persistent(true));
    }

    /** @test */
    public function it_checks_name()
    {
        $this->assertEquals('PHPSESSID', Session::setName('phpunit'));

        $this->assertEquals('phpunit', Session::getName());
    }

    /** @test */
    public function it_starts_session()
    {
        Session::persistent(true);

        $id = Session::start();

        $this->assertEquals(session_id(), $id);
    }

    /** @test */
    public function it_unserialize_data()
    {
        session_start();

        $_SESSION['foo'] = 'bar';

        $data = session_encode();

        $this->assertEquals(['foo' => 'bar'], Session::unserialize($data));
    }

    /** @test */
    public function it_resets_lifetime()
    {
        $this->assertTrue(Session::resetLifetime(10));
    }

    /** @test */
    public function it_gets_all_data_by_reference()
    {
        session_start();

        $_SESSION['a'] = 1;

        $_SESSION['b'] = 1;

        $this->assertEquals($_SESSION, Session::getRef());
    }

    /** @test */
    public function it_destroys_session()
    {
        session_start();

        $_SESSION['foo'] = 'bar';

        Session::destroy();

        $this->assertEquals([], $_SESSION);
    }
}
