<?php

declare(strict_types=1);

namespace App\Builders;

use App\Http\Controllers\Controller;
use App\Models\BullhornHttpQuery;
use Carbon\Carbon;

class BullhornHttpQueryBuilder extends Controller
{
    public const JOB_ORDER_STATUS_PROFFER = 'Aanbieden';

    public function buildJobOrdersQuery(carbon $fromDate, carbon $toDate, ?string $status): BullhornHttpQuery
    {
        $where = new WhereConditionBuilder();

        $where->pushWhereCondition('isDeleted', '=', false);
        $where->pushWhereCondition('dateAdded', '>', intval($fromDate->getPreciseTimestamp(3)));
        $where->pushWhereCondition('dateAdded', '<', intval($toDate->getPreciseTimestamp(3)));
        if (null !== $status) {
            $where->pushWhereCondition('status', '=', $status);
        }

        $field = new FieldsBuilder();

        $field->pushField('id');
        $field->pushField('dateAdded');
        $field->pushField('status');
        $field->pushField('isDeleted');
        $field->pushField('title');

        return new BullhornHttpQuery('GET', 'JobOrder', $where->getFormattedWhereClause(), $field->getFormattedFields());
    }
}
