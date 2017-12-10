<?php

/*
 * This file is part of the cibot project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Resolver;

use App\Resolver\ConfigResolver;
use PHPUnit\Framework\TestCase;

/**
 * @author Michael COULLERET <michael@coulleret.pro>
 */
class ConfigResolverTest extends TestCase
{
    /**
     * @var array
     */
    protected $config = [
        'default_branch' => 'develop',
    ];

    /**
     * @var ConfigResolver
     */
    private $resolver;

    public function setUp()
    {
        $this->resolver = new ConfigResolver($this->config, 'test');
    }

    public function testThrownExceptionOnGetConfigWhenNotExists()
    {
        $this->expectException(\RuntimeException::class);

        $this->resolver->getConfig('bot_name');
    }

    public function testMustRetrieveValueWhenAskConfig()
    {
        $value = $this->resolver->getConfig('default_branch');

        $this->assertSame($value, $this->config['default_branch']);
    }

    public function testIsPropagationWhenEnvironmentIsTest()
    {
        $this->assertFalse($this->resolver->isPropagateOnAPI());
    }
}
