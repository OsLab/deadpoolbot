<?php

/*
 * This file is part of the ci-bot project.
 *
 * (c) OsLab <https://github.com/OsLab>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Compiler;

use App\Chain\TransformerChain;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Transformers compiler pass.
 *
 * @author Michael COULLERET <michael@coulleret.pro>
 */
class TransformerCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition(TransformerChain::class)) {
            return;
        }

        $definition = $container->getDefinition(TransformerChain::class);

        $taggedServices = $container->findTaggedServiceIds(
            'app.transformers'
        );

        foreach ($taggedServices as $id => $tags) {
            foreach ($tags as $attributes) {
                $definition->addMethodCall(
                    'addTransformer',
                    [new Reference($id), $attributes['alias']]
                );
            }
        }
    }
}
