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
use Widop\HttpAdapterBundle\DependencyInjection\WidopHttpAdapterExtension;
use RequestLab\XitiAnalyticsBundle\DependencyInjection\RequestLabXitiAnalyticsExtension;

/**
 * Abstract RequestLab xiti analytics extension test.
 *
 * @author Yann Lecommandoux <yann@requestlab.fr>
 */
abstract class AbstractRequestLabXitiAnalyticsExtensionTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Symfony\Component\DependencyInjection\ContainerBuilder */
    protected $container;

    /**
     * {@ineritdoc}
     */
    protected function setUp()
    {
        $this->container = new ContainerBuilder();
        $this->container->setParameter('bundle.dir', realpath(__DIR__.'/../../'));
        $this->container->registerExtension($extension = new WidopHttpAdapterExtension());
        $this->container->loadFromExtension($extension->getAlias());
        $this->container->registerExtension(new RequestLabXitiAnalyticsExtension());
    }

    /**
     * {@ineritdoc}
     */
    protected function tearDown()
    {
        unset($this->container);
    }

    /**
     * Loads a configuration.
     *
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container     The container builder.
     * @param string                                                  $configuration The configuration name.
     */
    abstract protected function loadConfiguration(ContainerBuilder $container, $configuration);

    public function testXitiAnalyticsService()
    {
        $this->loadConfiguration($this->container, 'xiti_analytics');
        $this->container->compile();

        $xitiAnalytics = $this->container->get('request_lab_xiti_analytics');

        $this->assertInstanceOf('RequestLab\XitiAnalytics\Service', $xitiAnalytics);
        $this->assertSame('Login', $xitiAnalytics->getClient()->getLogin());
        $this->assertSame('Password', $xitiAnalytics->getClient()->getPassword());
    }

    public function testQueryService()
    {
        $this->loadConfiguration($this->container, 'xiti_analytics');
        $this->container->compile();

        $query = $this->container->get('request_lab_xiti_analytics.query');

        $this->assertInstanceOf('RequestLab\XitiAnalytics\Query', $query);
    }

    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testLoginRequired()
    {
        $this->loadConfiguration($this->container, 'login');
        $this->container->compile();
    }

    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testPasswordRequired()
    {
        $this->loadConfiguration($this->container, 'password');
        $this->container->compile();
    }

    /**
     * @expectedException Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException
     */
    public function testInvalidHttpAdapter()
    {
        $this->loadConfiguration($this->container, 'http_adapter');
        $this->container->compile();
    }
}