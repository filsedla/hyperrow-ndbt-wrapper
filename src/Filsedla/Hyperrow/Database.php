<?php
/**
 * Copyright (c) 2015 Filip Sedlacek <filsedla@gmail.com>
 */

namespace Filsedla\Hyperrow;

use Nette\Database\Context;
use Nette\InvalidStateException;
use Nette\Object;
use Nette\Utils\Callback;

/**
 * @property-read Context $context
 */
class Database extends Object
{
    /** @var Context */
    private $context;

    /** @var Factory */
    private $factory;

    /** @var Config */
    private $config;

    /** @var int */
    private $transactionLevel = 0;


    /**
     * @param Context $context
     * @param Factory $factory
     * @param Config $config
     */
    public function __construct(Context $context, Factory $factory, Config $config)
    {
        $this->context = $context;
        $this->factory = $factory;
        $this->config = $config;
    }


    /**
     * @param string $tableName
     * @return HyperSelection
     */
    public function table($tableName)
    {
        $selection = $this->context->table($tableName);
        return $this->factory->createSelection($selection);
    }


    /**
     * @return void
     */
    public function beginTransaction()
    {
        if ($this->config->isNestedTransactions()) {

            if ($this->transactionLevel == 0) {
                $this->context->beginTransaction();

            } elseif ($this->transactionLevel > 0) {
                $this->context->query("SAVEPOINT level{$this->transactionLevel}");

            } else {
                throw new InvalidStateException("Negative transaction level. Check if each commit/rollBack has its corresponding beginTransaction.");
            }

            $this->transactionLevel++;

        } else {
            $this->context->beginTransaction();
        }
    }


    /**
     * @return void
     */
    public function commit()
    {
        if ($this->config->isNestedTransactions()) {

            $this->transactionLevel--;

            if ($this->transactionLevel == 0) {
                $this->context->commit();

            } elseif ($this->transactionLevel > 0) {
                $this->context->query("RELEASE SAVEPOINT level{$this->transactionLevel}");

            } else {
                throw new InvalidStateException("Negative transaction level. Check if each commit/rollBack has its corresponding beginTransaction.");
            }

        } else {
            $this->context->commit();
        }
    }


    /**
     * @return void
     */
    public function rollBack()
    {
        if ($this->config->isNestedTransactions()) {

            $this->transactionLevel--;

            if ($this->transactionLevel == 0) {
                $this->context->rollBack();

            } elseif ($this->transactionLevel > 0) {
                $this->context->query("ROLLBACK TO SAVEPOINT level{$this->transactionLevel}");

            } else {
                throw new InvalidStateException("Negative transaction level. Check if each commit/rollBack has its corresponding beginTransaction.");
            }

        } else {
            $this->context->rollBack();
        }
    }


    /**
     * Run callback in a transaction
     *
     * @param \callable $callback
     * @return mixed
     * @throws \Exception
     */
    public function transaction($callback)
    {
        $this->beginTransaction();

        try {
            $return = Callback::invoke($callback);

        } catch (\Exception $e) {
            $this->rollBack();
            throw $e;
        }

        $this->commit();

        return $return;
    }


    /**
     * @return Context
     */
    public function getContext()
    {
        return $this->context;
    }

}
