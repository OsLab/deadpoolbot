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
 * Note transformer.
 *
 * @author Michael COULLERET <michael@coulleret.pro>
 */
final class NoteTransformer implements TransformerInterface
{
    public function transform(array $data): Note
    {
        return (new Note())
        ;
    }
}
