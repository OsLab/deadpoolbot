<?php

/*
 * This file is part of the ci-bot project.
 *
 * (c) OsLab <https://github.com/OsLab>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Compiler;

use App\Chain\TransformerChain;
use App\Compiler\TransformerCompilerPass;
use App\Transformer\MergeRequestTransformer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * @author Michael COULLERET <michael@coulleret.pro>
 */
class TransformerCompilerPassTest extends TestCase
{
    public function testProcessWithAddCompiler()
    {
        $container = new ContainerBuilder();

        $container->register('process_transformer', '\stdClass');

        $transformerCompilerPass = new TransformerCompilerPass();

        $container->addCompilerPass($transformerCompilerPass);

        $transformerCompilerPass->process($container);

        $this->assertSame($container->getDefinition('process_transformer')->getClass(), '\stdClass');
    }

    public function testProcessWithTagAndAlias()
    {
        $container = new ContainerBuilder();

        $definition = new Definition(TransformerChain::class);
        $definition->setPublic(true);
        $container->setDefinition(TransformerChain::class, $definition);

        $definition = new Definition(MergeRequestTransformer::class);
        $definition->addTag('app.transformer', ['alias' => 'merge_request']);
        $container->setDefinition(MergeRequestTransformer::class, $definition);

        $processorCompilerPass = new TransformerCompilerPass();

        $processorCompilerPass->process($container);

        $this->assertSame($definition->getTag('app.transformer'), [['alias' => 'merge_request']]);
    }
}
