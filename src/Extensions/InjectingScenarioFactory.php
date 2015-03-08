<?php namespace Keios\LaravelApparatus\Extensions;

use Illuminate\Contracts\Container\Container;
use Keios\Apparatus\Contracts\LoaderInterface;
use Keios\Apparatus\Core\ScenarioFactory;

class InjectingScenarioFactory extends ScenarioFactory
{
    protected $serviceContainer;

    /**
     * {@inheritdoc}
     */
    public function __construct(LoaderInterface $scenarioLoader, Container $serviceContainer)
    {
        $this->getScenariosFrom($scenarioLoader);
        $this->$serviceContainer = $serviceContainer;
    }

    /**
     * {@inheritdoc}
     */
    protected function make($eventName)
    {
        $scenarioClassName = $this->registeredScenarios[$eventName];

        if (is_callable($scenarioClassName)) {
            return $this->resolveClosure($scenarioClassName);
        }

        return $this->serviceContainer->make($scenarioClassName);
    }
}