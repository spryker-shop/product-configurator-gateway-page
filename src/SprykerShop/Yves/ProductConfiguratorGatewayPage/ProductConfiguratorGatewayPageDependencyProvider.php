<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\ProductConfiguratorGatewayPage;

use Spryker\Yves\Kernel\AbstractBundleDependencyProvider;
use Spryker\Yves\Kernel\Container;
use SprykerShop\Yves\ProductConfiguratorGatewayPage\Dependency\Client\ProductConfiguratorGatewayPageToProductConfigurationClientBridge;
use SprykerShop\Yves\ProductConfiguratorGatewayPage\Dependency\Client\ProductConfiguratorGatewayPageToProductConfigurationStorageClientBridge;
use SprykerShop\Yves\ProductConfiguratorGatewayPage\Dependency\Client\ProductConfiguratorGatewayPageToProductStorageClientBridge;
use SprykerShop\Yves\ProductConfiguratorGatewayPage\Dependency\Client\ProductConfiguratorGatewayPageToQuoteClientBridge;

class ProductConfiguratorGatewayPageDependencyProvider extends AbstractBundleDependencyProvider
{
    public const CLIENT_QUOTE = 'CLIENT_QUOTE';
    public const CLIENT_PRODUCT_CONFIGURATION_STORAGE = 'CLIENT_PRODUCT_CONFIGURATION_STORAGE';
    public const CLIENT_PRODUCT_CONFIGURATION = 'CLIENT_PRODUCT_CONFIGURATION';
    public const CLIENT_PRODUCT_STORAGE = 'CLIENT_PRODUCT_STORAGE';
    public const PLUGINS_PRODUCT_CONFIGURATOR_GATEWAY_BACK_URL_RESOLVER_STRATEGY = 'PLUGINS_PRODUCT_CONFIGURATOR_GATEWAY_BACK_URL_RESOLVER_STRATEGY';

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
        $container = parent::provideDependencies($container);

        $container = $this->addQuoteClient($container);
        $container = $this->addProductConfigurationStorageClient($container);
        $container = $this->addProductConfigurationClient($container);
        $container = $this->addProductConfiguratorGatewayBackUrlResolverStrategyPlugins($container);
        $container = $this->addProductStorageClient($container);

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addProductStorageClient(Container $container)
    {
        $container->set(static::CLIENT_PRODUCT_STORAGE, function (Container $container) {
            return new ProductConfiguratorGatewayPageToProductStorageClientBridge($container->getLocator()->productStorage()->client());
        });

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addQuoteClient(Container $container): Container
    {
        $container->set(static::CLIENT_QUOTE, function (Container $container) {
            return new ProductConfiguratorGatewayPageToQuoteClientBridge(
                $container->getLocator()->quote()->client()
            );
        });

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addProductConfigurationStorageClient(Container $container): Container
    {
        $container->set(static::CLIENT_PRODUCT_CONFIGURATION_STORAGE, function (Container $container) {
            return new ProductConfiguratorGatewayPageToProductConfigurationStorageClientBridge(
                $container->getLocator()->productConfigurationStorage()->client()
            );
        });

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addProductConfigurationClient(Container $container): Container
    {
        $container->set(static::CLIENT_PRODUCT_CONFIGURATION, function (Container $container) {
            return new ProductConfiguratorGatewayPageToProductConfigurationClientBridge(
                $container->getLocator()->productConfiguration()->client()
            );
        });

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addProductConfiguratorGatewayBackUrlResolverStrategyPlugins(Container $container): Container
    {
        $container->set(static::PLUGINS_PRODUCT_CONFIGURATOR_GATEWAY_BACK_URL_RESOLVER_STRATEGY, function () {
            return $this->getProductConfiguratorGatewayBackUrlResolverStrategyPlugins();
        });

        return $container;
    }

    /**
     * @return \SprykerShop\Yves\ProductConfiguratorGatewayPageExtension\Dependency\Plugin\ProductConfiguratorGatewayBackUrlResolverStrategyPluginInterface[]
     */
    protected function getProductConfiguratorGatewayBackUrlResolverStrategyPlugins(): array
    {
        return [];
    }
}
