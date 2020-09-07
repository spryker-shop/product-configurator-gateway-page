<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\ProductConfiguratorGatewayPage;

use Spryker\Shared\Application\ApplicationConstants;
use Spryker\Yves\Kernel\AbstractFactory;
use SprykerShop\Yves\ProductConfiguratorGatewayPage\Dependency\Client\ProductConfiguratorGatewayPageToProductConfigurationClientInterface;
use SprykerShop\Yves\ProductConfiguratorGatewayPage\Dependency\Client\ProductConfiguratorGatewayPageToProductConfigurationStorageClientInterface;
use SprykerShop\Yves\ProductConfiguratorGatewayPage\Dependency\Client\ProductConfiguratorGatewayPageToQuoteClientInterface;
use SprykerShop\Yves\ProductConfiguratorGatewayPage\Form\ProductConfiguratorRequestDataForm;
use SprykerShop\Yves\ProductConfiguratorGatewayPage\Mapper\ProductConfiguratorRequestDataMapper;
use SprykerShop\Yves\ProductConfiguratorGatewayPage\Mapper\ProductConfiguratorRequestDataMapperInterface;
use SprykerShop\Yves\ProductConfiguratorGatewayPage\Mapper\ProductConfiguratorResponseDataMapper;
use SprykerShop\Yves\ProductConfiguratorGatewayPage\Mapper\ProductConfiguratorResponseDataMapperInterface;
use SprykerShop\Yves\ProductConfiguratorGatewayPage\Resolver\ProductConfiguratorRedirectResolver;
use SprykerShop\Yves\ProductConfiguratorGatewayPage\Resolver\ProductConfiguratorRedirectResolverInterface;
use Symfony\Component\Form\FormInterface;

/**
 * @method \SprykerShop\Yves\ProductConfiguratorGatewayPage\ProductConfiguratorGatewayPageConfig getConfig()
 */
class ProductConfiguratorGatewayPageFactory extends AbstractFactory
{
    /**
     * @return \SprykerShop\Yves\ProductConfiguratorGatewayPage\Mapper\ProductConfiguratorRequestDataMapperInterface
     */
    public function createProductConfiguratorRequestDataMapper(): ProductConfiguratorRequestDataMapperInterface
    {
        return new ProductConfiguratorRequestDataMapper();
    }

    /**
     * @return \SprykerShop\Yves\ProductConfiguratorGatewayPage\Mapper\ProductConfiguratorResponseDataMapperInterface
     */
    public function createProductConfiguratorResponseDataMapper(): ProductConfiguratorResponseDataMapperInterface
    {
        return new ProductConfiguratorResponseDataMapper();
    }

    /**
     * @return \SprykerShop\Yves\ProductConfiguratorGatewayPage\Resolver\ProductConfiguratorRedirectResolverInterface
     */
    public function createProductConfiguratorRedirectResolver(): ProductConfiguratorRedirectResolverInterface
    {
        return new ProductConfiguratorRedirectResolver(
            $this->createProductConfiguratorRequestDataMapper(),
            $this->getProductConfigurationClient(),
            $this->getProductConfigurationStorageClient(),
            $this->getQuoteClient()
        );
    }

    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getProductConfiguratorRequestDataForm(): FormInterface
    {
        return $this->getFormFactory()->createNamed(
            $this->getConfig()->getProductConfiguratorGatewayRequestFormName(),
            ProductConfiguratorRequestDataForm::class
        );
    }

    /**
     * @return \Symfony\Component\Form\FormFactory
     */
    public function getFormFactory()
    {
        return $this->getProvidedDependency(ApplicationConstants::FORM_FACTORY);
    }

    /**
     * @return \SprykerShop\Yves\ProductConfiguratorGatewayPageExtension\Dependency\Plugin\ProductConfiguratorGatewayBackUrlResolverStrategyPluginInterface[]
     */
    public function getProductConfiguratorGatewayBackUrlResolverStrategyPlugins(): array
    {
        return $this->getProvidedDependency(ProductConfiguratorGatewayPageDependencyProvider::PLUGINS_PRODUCT_CONFIGURATOR_GATEWAY_BACK_URL_RESOLVER_STRATEGY);
    }

    /**
     * @return \SprykerShop\Yves\ProductConfiguratorGatewayPage\Dependency\Client\ProductConfiguratorGatewayPageToQuoteClientInterface
     */
    public function getQuoteClient(): ProductConfiguratorGatewayPageToQuoteClientInterface
    {
        return $this->getProvidedDependency(ProductConfiguratorGatewayPageDependencyProvider::CLIENT_QUOTE);
    }

    /**
     * @return \SprykerShop\Yves\ProductConfiguratorGatewayPage\Dependency\Client\ProductConfiguratorGatewayPageToProductConfigurationStorageClientInterface
     */
    public function getProductConfigurationStorageClient(): ProductConfiguratorGatewayPageToProductConfigurationStorageClientInterface
    {
        return $this->getProvidedDependency(ProductConfiguratorGatewayPageDependencyProvider::CLIENT_PRODUCT_CONFIGURATION_STORAGE);
    }

    /**
     * @return \SprykerShop\Yves\ProductConfiguratorGatewayPage\Dependency\Client\ProductConfiguratorGatewayPageToProductConfigurationClientInterface
     */
    public function getProductConfigurationClient(): ProductConfiguratorGatewayPageToProductConfigurationClientInterface
    {
        return $this->getProvidedDependency(ProductConfiguratorGatewayPageDependencyProvider::CLIENT_PRODUCT_CONFIGURATION);
    }
}
