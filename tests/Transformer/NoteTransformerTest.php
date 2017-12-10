<?php

/*
 * This file is part of the cibot project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Transformer;

use App\Transformer\NoteTransformer;
use PHPUnit\Framework\TestCase;

/**
 * @author Michael COULLERET <michael@coulleret.pro>
 */
class NoteTransformerTest extends TestCase
{
    /**
     * @var NoteTransformer
     */
    private $transformer;

    public function setUp()
    {
        $this->transformer = new NoteTransformer();
    }

    public function testTransformMergeRequest()
    {
        $stubsJson = file_get_contents(__DIR__.'/../Stubs/note.json');
        $items = json_decode($stubsJson, true);

        $object = $this->transformer->transform($items);

        $this->assertSame($object->getIid(), '2');
        $this->assertSame($object->getObjectId(), 23516);
        $this->assertSame($object->getNote(), 'Ab in suam fractis nomine.');
        $this->assertSame($object->getUrl(), 'https://gitlab.domain/michael.coulleret/recette-ci/merge_requests/2#note_127455');
        $this->assertSame($object->getUsername(), 'michael.coulleret');
        $this->assertTrue($object->isWorkInProgress());
    }
}
