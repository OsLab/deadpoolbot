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

use App\Entity\Note;

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
            ->setIid($data['merge_request']['iid'])
            ->setObjectId($data['merge_request']['id'])
            ->setNote($data['object_attributes']['note'])
            ->setUrl($data['object_attributes']['url'])
            ->setUsername($data['user']['username'])
            ->setWorkInProgress($data['merge_request']['work_in_progress'])
            ->setWorkInProgress($data['merge_request']['state'])
        ;
    }
}
