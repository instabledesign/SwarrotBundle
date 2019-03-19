<?php

namespace Swarrot\SwarrotBundle\Processor\XDeath;

use Psr\Log\LoggerInterface;
use Swarrot\Broker\Message;
use Swarrot\SwarrotBundle\Processor\ProcessorConfiguratorEnableAware;
use Swarrot\SwarrotBundle\Processor\ProcessorConfiguratorExtrasAware;
use Swarrot\SwarrotBundle\Processor\ProcessorConfiguratorInterface;
use Symfony\Component\Console\Input\InputInterface;

class XDeathMaxCountProcessorConfigurator implements ProcessorConfiguratorInterface
{
    use ProcessorConfiguratorEnableAware, ProcessorConfiguratorExtrasAware;

    /**
     * @var string
     */
    private $processorClass;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param                      $processorClass
     * @param LoggerInterface|null $logger
     */
    public function __construct($processorClass, LoggerInterface $logger = null)
    {
        $this->processorClass = $processorClass;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function getProcessorArguments(array $options)
    {
        if (null === $exceptionHandler = $this->getExtra('max_count_exception_handler')) {
            throw new \LogicException('you must provide the "max_count_exception_handler" extra configuration.');
        }

        return [
            $this->processorClass,
            $options['queue'],
            $exceptionHandler,
            $this->logger
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getCommandOptions()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function resolveOptions(InputInterface $input)
    {
        return $this->getExtras();
    }
}
