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

use App\Entity\MergeRequest;

/**
 * Merge request transformer.
 *
 * @author Michael COULLERET <michael@coulleret.pro>
 */
final class MergeRequestTransformer implements TransformerInterface
{
    public function transform(array $data): MergeRequest
    {
        return (new MergeRequest())
            ->setIid($data['object_attributes']['iid'])
            ->setProjectId($data['object_attributes']['target_project_id'])
            ->setObjectId($data['object_attributes']['id'])
            ->setUrl($data['object_attributes']['url'])
            ->setSourceBranch($data['object_attributes']['source_branch'])
            ->setLastCommitId($data['object_attributes']['last_commit']['id'])
            ->setTitle($data['object_attributes']['title'])
            ->setUsername($data['user']['username'])
        ;
    }
}
