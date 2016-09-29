<?php
namespace Admin\Profiler;

class FirePhpProfiler implements \Doctrine\DBAL\Logging\SQLLogger
{
    private $enabled      = true;
    private $start        = 0;
    private $end          = 0;
    private $queries      = array();
    private $currentQuery = null;

    /**
     * $logger FirePHP
     */
    private $logger;

    public function __construct()
    {
        $this->logger    = new \FirePHP();
        $this->queries[] = array('Time', 'Query', 'Parameters');
    }

    /**
     * {@inheritdoc}
     */
    public function startQuery($sql, array $params = null, array $types = null)
    {
        if (! $this->start) {
            $this->start = \microtime(true);
        }

        $this->currentQuery            = new \stdClass();
        $this->currentQuery->sql       = $sql;
        $this->currentQuery->params    = $params;
        $this->currentQuery->types     = $types;
        $this->currentQuery->startTime = \microtime(true);
    }

    /**
     * {@inheritdoc}
     */
    public function stopQuery()
    {
        $executionTime = \microtime(true) - $this->currentQuery->startTime;

        $this->queries[] = array(
            number_format($executionTime, 4),
            $this->currentQuery->sql,
            $this->currentQuery->params,
        );

        $this->end = \microtime(true);
    }

    /**
     * showTable dispaly FirePHP table
     */
    public function showTable()
    {
        if (headers_sent()) {
            return;
        }

        if (! empty($this->queries) && count($this->queries) > 1) {
            $this->logger->table(
                sprintf(
                    'Doctrine Queries (%d @ %s sec)',
                    count($this->queries) - 1,
                    number_format($this->end - $this->start, 4)
                ),
                $this->queries
            );
        }
    }
}