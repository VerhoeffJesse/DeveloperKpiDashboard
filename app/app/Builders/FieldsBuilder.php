<?php

declare(strict_types=1);

namespace App\Builders;

class FieldsBuilder
{
    protected array $fields = [];

    public function pushField(string $field): void
    {
        $this->fields[] = $field;
    }

    public function getFields(): array
    {
        return $this->fields;
    }

    public function getFormattedFields(): string
    {
        return 'fields=' . implode(',', $this->fields);
    }
}
