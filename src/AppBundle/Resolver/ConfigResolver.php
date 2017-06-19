<?php

/*
 * This file is part of the DeadPool Bot project.
 *
 * (c) OsLab <https://github.com/OsLab>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Resolver;

/**
 * Config resolver.
 *
 * @author Michael COULLERET <michael.coulleret@gmail.com>
 * @author Florent DESPIERRES <orions07@gmail.com>
 */
class ConfigResolver
{
    /**
     * @var array
     */
    private $parameters;

    /**
     * Constructor.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters = [])
    {
        $this->parameters = $parameters;
    }

    /**
     * Get parameter config.
     *
     * @param string $name
     *
     * @return string
     */
    public function getConfig($name)
    {
        if (!isset($this->parameters[$name])) {
            throw new \RuntimeException(sprintf('Parameter %s does not exists', $name));
        }

        return $this->parameters[$name];
    }
}
