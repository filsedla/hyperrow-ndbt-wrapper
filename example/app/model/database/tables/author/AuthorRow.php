<?php

/**
 * This is a generated file. You CAN EDIT it, it was generated only once. It will not be overwritten.
 */

namespace Example\Model\Database;

use Example\Model\DummyProcessingService;

class AuthorRow extends AuthorGeneratedRow
{

    /** @var DummyProcessingService */
    protected $dummyProcessingService;


    /**
     * @param DummyProcessingService $dummyProcessingService
     */
    public function __construct(DummyProcessingService $dummyProcessingService)
    {
        $this->dummyProcessingService = $dummyProcessingService;
    }


    /**
     * @return string
     */
    public function getProcessedName()
    {
        return $this->dummyProcessingService->process($this->name);
    }
}
