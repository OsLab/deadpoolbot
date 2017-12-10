<?php

/*
 * This file is part of the cibot project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Transformer;

use App\Transformer\MergeRequestTransformer;
use App\Transformer\TransformerInterface;
use PHPUnit\Framework\TestCase;

/**
 * @author Michael COULLERET <michael@coulleret.pro>
 */
class MergeRequestTransformerTest extends TestCase
{
    /**
     * @var MergeRequestTransformer
     */
    private $transformer;

    public function setUp()
    {
        $this->transformer = new MergeRequestTransformer();
    }

    public function testTransformMergeRequest()
    {
        $stubsJson = file_get_contents(__DIR__.'/../Stubs/merge_request.json');
        $items = json_decode($stubsJson, true);

        $object = $this->transformer->transform($items);

        $this->assertSame($object->getIid(), '2');
        $this->assertSame($object->getProjectId(), 4431);
        $this->assertSame($object->getObjectId(), 23516);
        $this->assertSame($object->getSourceBranch(), 'master');
        $this->assertSame($object->getLastCommitId(), '10a61c6e91fc09d1d6e449cd9d3765ab21a8ea23');
        $this->assertSame($object->getTitle(), 'Init');
        $this->assertSame($object->getUsername(), 'michael.coulleret');
    }
}
