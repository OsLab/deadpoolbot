<?php

/*
 * This file is part of the cibot project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Smoke test.
 */
class BoardControllerTest extends WebTestCase
{
    /**
     * @dataProvider getUrls
     */
    public function testUrls($url)
    {
        $client = static::createClient();

        $client->request('GET', $url);

        $this->assertSame(
            Response::HTTP_OK,
            $client->getResponse()->getStatusCode()
        );
    }

    public function getUrls()
    {
        yield ['/'];
    }
}
