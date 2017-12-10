<?php

/*
 * This file is part of the ci-bot project.
 *
 * (c) OsLab <https://github.com/OsLab>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Chain;

use App\Transformer\TransformerInterface;

/**
 * Transformer chain of responsibility.
 *
 * @author Michael COULLERET <michael@coulleret.pro>
 */
class TransformerChain
{
    /**
     * @var array
     */
    private $transformers = [];

    /**
     * Add transformer with an alias.
     */
    public function addTransformer(TransformerInterface $transformer, string $alias): self
    {
        $this->transformers[$alias] = $transformer;

        return $this;
    }

    /**
     * Get transformer by its alias.
     */
    public function getTransformer(string $alias): TransformerInterface
    {
        if (array_key_exists($alias, $this->transformers)) {
            return $this->transformers[$alias];
        }

        throw new \RuntimeException(sprintf('Transformer %s not exist', $alias));
    }

    public function getTransformers(): array
    {
        return $this->transformers;
    }
}
