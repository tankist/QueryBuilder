<?php

namespace Query;

/**
 *
 * Query
 *
 * @package Query
 * @copyright (c) Vicente Mendoza <chentepixtol@gmail.com>
 * @author chentepixtol
 */
class Update extends ManipulationStatement implements Criterion
{

    /**
     *
     * @var Sets;
     */
    private $setPart;

    /**
     *
     * Construct
     * @param QuoteStrategy $quoteStrategy
     */
    public function __construct(QuoteStrategy $quoteStrategy = null){
        $this->setPart = new Sets();
        parent::__construct($quoteStrategy);
        $this->fromPart->setKeyword("");
    }

    /**
     *
     * @return string
     */
    public function createSql(){

        $parts = array(
            $this->createFromSql(),
            $this->createSetSql(),
            $this->createJoinSql(),
            $this->createWhereSql(),
            $this->createLimitSql(),
        );

        $sql = "UPDATE " . implode(' ', array_filter($parts));

        return $this->replaceParameters($sql);
    }

    /**
     * @return MongoQuery
     */
    public function createMongoQuery(){

    }

    /**
     * @return string
     */
    public function createSetSql(){
        return $this->setPart->createSql();
    }

    /**
     *
     * @param string $column
     * @param mixed $value
     * @param string $mutator
     * @return self
     */
    public function addSet($column, $value, $mutator = null){
        $this->setPart->add($column, $value, $mutator);
        return $this;
    }

    /**
     *
     * @param string $column
     * @param mixed $value
     * @return self
     */
    public function addSets($sets){
        foreach ($sets as $column => $value){
            $this->addSet($column, $value);
        }
    }

    /**
     * (non-PHPdoc)
     * @see Criterion::setQuoteStrategy()
     */
    public function setQuoteStrategy(QuoteStrategy $quoteStrategy){
        parent::setQuoteStrategy($quoteStrategy);
        $this->setPart->setQuoteStrategy($quoteStrategy);
    }

}
