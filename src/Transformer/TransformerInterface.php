<?php

/*
 * This file is part of the ci-bot project.
 *
 * (c) OsLab <https://github.com/OsLab>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Transformer;

/**
 * Interface TransformerInterface.
 *
 * @author Michael COULLERET <michael@coulleret.pro>
 */
interface TransformerInterface
{
    /**
     * Transform to data array to object.
     */
    public function transform(array $data);
}
