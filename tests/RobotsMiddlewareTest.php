<?php

namespace Spatie\RobotsMiddleware\Test;

class RobotsMiddlewareTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->setUpDummyRoutes();
    }

    /** @test */
    public function it_always_adds_a_robots_header_tag()
    {
        $testRoutes = ['behold-me', 'go-away'];

        foreach ($testRoutes as $testRoute) {
            $headers = $this->call('get', $testRoute)->headers->all();
            $this->assertArrayHasKey('X-Robots-Tag', $headers);
        }
    }

    /** @test */
    public function it_sets_the_robots_header_to_all_when_it_should_index()
    {
        $headers = $this->call('get', 'behold-me')->headers->all();
        print_r($headers);
        $this->assertEquals('all', $headers['X-Robots-Tag'][0]);
    }

    /** @test */
    public function it_sets_the_robots_header_to_none_when_it_shouldnt_index()
    {
        $headers = $this->call('get', 'go-away')->headers->all();
        $this->assertEquals('none', $headers['X-Robots-Tag'][0]);
    }

    /** @test */
    public function it_doesnt_overwrite_previously_set_tags()
    {
        $headers = $this->call('get', 'dont-follow-me')->headers->all();
        $this->assertEquals('nofollow', $headers['X-Robots-Tag'][0]);
    }

    /** @test */
    public function it_can_set_a_custom_tag_via_a_string()
    {
        $headers = $this->call('get', 'custom-tag')->headers->all();
        $this->assertEquals('nofollow', $headers['X-Robots-Tag'][0]);
    }
}
