<?php

/*
 * This file is part of the cibot project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Smoke test.
 */
class WebhookControllerTest extends WebTestCase
{
    /**
     * @dataProvider getPublicUrls
     */
    public function testPublicUrls($verb, $url, $body)
    {
        $client = static::createClient();

        $client->request($verb, $url, [], [], [], $body);

        $this->assertSame(
            Response::HTTP_OK,
            $client->getResponse()->getStatusCode(),
            sprintf('The %s public URL loads correctly.', $url)
        );
    }

    public function getPublicUrls()
    {
        yield ['POST', '/webhooks/gitlab', $this->loadStub('merge_request.json')];
    }

    private function loadStub($file): string
    {
        return file_get_contents(sprintf('%s/../Stubs/%s', __DIR__, $file));
    }
}
