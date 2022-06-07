<?php

namespace App\Builders;

use App\Models\WhereConditionModel;

class WhereConditionBuilder
{
    protected array $whereConditions = [];

    /**
     * Add a new where condition to the array where's to create multiple where statements
     * @param string $field
     * @param string $logicOperator
     * @param int|string|bool $condition
     * @return void
     */
    public function pushWhereCondition(string $field, string $logicOperator, int|string|bool $condition): void
    {
        $this->whereConditions[] = new WhereConditionModel($field, $logicOperator, $condition);
    }

    /**
     * Gets the array full of where statements
     * @return array
     */
    public function getWhereConditions(): array
    {
        return $this->whereConditions;
    }

    /**
     * Gets the where statement prepared for the query
     * @return string
     */
    public function getFormattedWhereClause(): string
    {
        $formattedWhereClause = 'where=';
        foreach ($this->getWhereConditions() as $key => $whereCondition) {
            // If the where is not the first join the two where's with an AND statement
            if ($key !== array_key_first($this->getWhereConditions())) {
                $formattedWhereClause .= ' AND ';
            }

            $formattedWhereClause .= (string) $whereCondition;
        }

        return $formattedWhereClause;
    }
}
