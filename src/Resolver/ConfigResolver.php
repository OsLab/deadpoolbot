<?php

/*
 * This file is part of the ci-bot project.
 *
 * (c) OsLab <https://github.com/OsLab>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Resolver;

/**
 * Config resolver.
 *
 * @author Michael COULLERET <michael@coulleret.pro>
 * @author Florent DESPIERRES <florent@despierres.pro>
 */
class ConfigResolver
{
    /**
     * @var array
     */
    private $parameters;

    /**
     * @var string
     */
    private $environment;

    public function __construct(array $parameters = [], string $environment = 'prod')
    {
        $this->parameters = $parameters;
        $this->environment = $environment;
    }

    public function getConfig(string $name): string
    {
        if (!isset($this->parameters[$name])) {
            throw new \RuntimeException(sprintf('Parameter %s does not exists', $name));
        }

        return $this->parameters[$name];
    }

    public function isPropagateOnAPI(): bool
    {
        return 'test' !== $this->environment;
    }
}
