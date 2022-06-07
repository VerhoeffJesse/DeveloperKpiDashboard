<?php

namespace App\Models;

class BullhornHttpQuery
{
    protected string $method;
    protected string $url;
    protected string $where;
    protected string $field;

    /**
     * @param string $method
     * @param string $url
     * @param string $where
     * @param string $field
     */
    public function __construct(string $method, string $url, string $where, string $field)
    {
        $this->method = $method;
        $this->url = $url;
        $this->where = $where;
        $this->field = $field;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getUrl(): string
    {
        return "query/" .$this->url;
    }

    public function getWheres(): string
    {
        return $this->where;
    }

    public function getFields(): string
    {
        return $this->field;
    }
}
