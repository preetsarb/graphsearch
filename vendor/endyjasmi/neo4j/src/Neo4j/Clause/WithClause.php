<?php
/**
 * WithClause class file
 *
 * @package EndyJasmi\Neo4j\Clause;
 */
namespace EndyJasmi\Neo4j\Clause;

use EndyJasmi\Neo4j\QueryInterface;

/**
 * WithClause is a concrete implementation of clause interface
 */
class WithClause extends AbstractClause
{
    /**
     * @var array Field array
     */
    protected $fields = [];

    /**
     * @var ClauseInterface Limit instance
     */
    protected $limit;

    /**
     * @var ClauseInterface Order by instance
     */
    protected $order;

    /**
     * @var ClauseInterface Skip instance
     */
    protected $skip;

    /**
     * @var ClauseInterface Where instance
     */
    protected $where;

    /**
     * With clause constructor
     *
     * @param QueryInterface $parent Parent instance
     * @param string $field Name string
     * @param string $alias Alias string
     */
    public function __construct(QueryInterface $parent, $field, $alias = null)
    {
        $this->with($field, $alias)
            ->parent = $parent;
    }

    /**
     * Get parameter array
     *
     * @return array Return parameter array
     */
    public function getParameters()
    {
        $parameters = $this->parameters;

        if (! is_null($this->where)) {
            $parameters = array_merge($parameters, $this->where->getParameters());
        }

        if (! is_null($this->skip)) {
            $parameters = array_merge($parameters, $this->skip->getParameters());
        }

        if (! is_null($this->limit)) {
            $parameters = array_merge($parameters, $this->limit->getParameters());
        }

        return $parameters;
    }

    /**
     * Get query string
     *
     * @return string Return query string
     */
    public function getQuery()
    {
        $fields = array_map(
            function ($field) {
                $alias = $field[1];
                $field = $field[0];

                if (! is_null($alias)) {
                    $field = "$field AS $alias";
                }

                return $field;
            },
            $this->fields
        );

        $fields = implode(', ', $fields);

        if (! is_null($this->where)) {
            $where = $this->where->getQuery();

            $fields = "$fields $where";
        }

        if (! is_null($this->order)) {
            $orderBy = $this->order->getQuery();

            $fields = "$fields $orderBy";
        }

        if (! is_null($this->skip)) {
            $skip = $this->skip->getQuery();

            $fields = "$fields $skip";
        }

        if (! is_null($this->limit)) {
            $limit = $this->limit->getQuery();

            $fields = "$fields $limit";
        }

        return "WITH $fields";
    }

    /**
     * Limit rows
     *
     * @param integer $limit Row number
     * @param string $alias Alias string
     *
     * @return ClauseInterface Limit instance
     */
    public function limit($limit, $alias = 'limit')
    {
        return $this->limit = new LimitClause($this, $limit, $alias);
    }

    /**
     * Order by field
     *
     * @param string $field Name string
     * @param string $alias Alias string
     *
     * @return ClauseInterface Return order by instance
     */
    public function orderBy($field, $alias = null)
    {
        if (is_null($this->order)) {
            $this->order = new OrderByClause($this, $field, $alias);
        } else {
            $this->order->orderBy($field, $alias);
        }

        return $this->order;
    }

    /**
     * Skip row
     *
     * @param integer $skip Row number
     * @param string $alias Alias string
     *
     * @return ClauseInterface Return skip instance
     */
    public function skip($skip, $alias = 'skip')
    {
        return $this->skip = new SkipClause($this, $skip, $alias);
    }

    /**
     * Where condition
     *
     * @param string $condition Condition string
     * @param array $parameters Parameter array
     *
     * @return ClauseInterface Return where instance
     */
    public function where($condition, array $parameters = [])
    {
        return $this->where = new WhereClause($this, $condition, $parameters);
    }

    /**
     * With field
     *
     * @param string $field Name string
     * @param string $alias Alias string
     *
     * @return ClauseInterface Return self
     */
    public function with($field, $alias = null)
    {
        $this->fields[] = [$field, $alias];

        return $this;
    }
}
