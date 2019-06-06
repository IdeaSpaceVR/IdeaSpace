<?php

namespace Illuminate\Database\Schema;

class PostgresBuilder extends Builder
{
    /**
     * Determine if the given table exists.
     *
     * @param  string  $table
     * @return bool
     */
    public function hasTable($table)
    {
        $sql = $this->grammar->compileTableExists();

        $schema = $this->connection->getConfig('schema');

        $table = $this->connection->getTablePrefix().$table;

        return count($this->connection->select($sql, [$schema, $table])) > 0;
    }
}
