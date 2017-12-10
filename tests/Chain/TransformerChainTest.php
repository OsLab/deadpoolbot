<?php

/*
 * This file is part of the ci-bot project.
 *
 * (c) OsLab <https://github.com/OsLab>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Chain;

use App\Chain\TransformerChain;
use App\Transformer\MergeRequestTransformer;
use App\Transformer\TransformerInterface;
use PHPUnit\Framework\TestCase;

/**
 * @author Michael COULLERET <michael@coulleret.pro>
 */
class TransformerChainTest extends TestCase
{
    /**
     * @var TransformerChain
     */
    private $transformer;

    public function setUp()
    {
        $this->transformer = new TransformerChain();
    }

    public function testAddNewTransformer()
    {
        $transformer = $this->prophesize(TransformerInterface::class);
        $this->transformer->addTransformer($transformer->reveal(), 'merge_request');

        $this->assertCount(1, $this->transformer->getTransformers());
    }

    public function testGetProcessorMergeRequest()
    {
        $transformer = new MergeRequestTransformer();
        $this->transformer->addTransformer($transformer, 'merge_request');

        $this->assertInstanceOf(MergeRequestTransformer::class, $this->transformer->getTransformer('merge_request'));
    }
}
