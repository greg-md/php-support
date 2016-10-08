<?php

namespace Greg\Support\IoC;

trait IoCManagerAccessorTrait
{
    /**
     * @var IoCManagerInterface|null
     */
    protected $ioCManager = null;

    public function setIoCManager(IoCManagerInterface $ioCManager)
    {
        $this->ioCManager = $ioCManager;

        return $this;
    }

    public function getIoCManager()
    {
        return $this->ioCManager;
    }
}