<?php

declare(strict_types=1);

namespace App\Models;

use Stringable;

class WhereConditionModel
{
    public function __construct(
        protected string $fieldName,
        protected string $logicOperator,
        protected bool|int|float|string|object $condition
    ) {
        if (is_object($this->condition) && !($this->condition instanceof Stringable)) {
            throw new \InvalidArgumentException('Classes must be stringable when providing them as a where clause value');
        }
    }

    /**
     * For the query its necessary to encapsulate the condition with quotes
     *
     * Beware, var_export is used for non-strings and objects, an array will be shown as text,
     * see https://www.php.net/var_export
     */
    protected function formatConditionAsString(): string
    {
        // Add quotes to string, this is required for the query handler to process the value properly
        if (is_string($this->condition) || $this->condition instanceof Stringable) {
            return "'" . $this->condition . "'";
        }

        // Convert the variable to a string
        return var_export($this->condition, true);
    }

    public function __toString()
    {
        return $this->fieldName . $this->logicOperator . $this->formatConditionAsString();
    }
}
