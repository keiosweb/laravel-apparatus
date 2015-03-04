<?php namespace Keios\LaravelApparatus;

use Keios\Apparatus\Core\ScenarioConfiguration;

/**
 * Class RepositoryScenarioConfiguration
 *
 * @package Keios\LaravelApparatus
 */
class RepositoryScenarioConfiguration extends ScenarioConfiguration
{
    /**
     * @param $repository
     *
     * @throws \Exception
     */
    public function __construct($repository)
    {
        $bindings = $repository->get('keios.apparatus.scenarios');

        if (is_array($bindings)) {
            foreach ($bindings as $event => $scenarioClassName) {
                $this->bind($event, $scenarioClassName);
            }
        } else {
            throw new \Exception('Invalid Keios Apparatus configuration, scenario list is not an array.');
        }
    }
}