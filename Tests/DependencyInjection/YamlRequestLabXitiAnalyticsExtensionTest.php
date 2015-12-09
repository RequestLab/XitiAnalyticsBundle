<?php

/*
 * This file is part of the RequestLab package.
 *
 * (c) RequestLab <hello@requestlab.fr>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace RequestLab\XitiAnalyticsBundle\Tests\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;

/**
 * Yaml RequestLab xiti analytics extension test.
 *
 * @author Yann Lecommandoux <yann@requestlab.fr>
 */
class YamlRequestLabXitiAnalyticsExtensionTest extends AbstractRequestLabXitiAnalyticsExtensionTest
{
    /**
     * {@inheritdoc}
     */
    protected function loadConfiguration(ContainerBuilder $container, $configuration)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/Fixtures/Yaml/'));
        $loader->load($configuration.'.yml');
    }
}