<?php

namespace App\Services;

use App\Models\Bus;
use App\Models\Payment;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class BusRevenueService
{
    /**
     * Receita líquida por ônibus (pagos − estornos) no período.
     * Todos os ônibus cadastrados aparecem, mesmo sem receita (R$ 0,00);
     * ônibus não cadastrados só aparecem se tiverem movimento.
     */
    public function byBus($startDateTime, $endDateTime): Collection
    {
        $dateRange = [$startDateTime, $endDateTime];
        $busNames = Bus::getSerialNameMap();
        $busIdExpression = "COALESCE(NULLIF(JSON_UNQUOTE(JSON_EXTRACT(payments.payment_data, '$.transferred_mikrotik_id')), ''), users.last_mikrotik_id, 'desconhecido')";

        $totalsFor = fn (string $status) => Payment::where('payments.status', $status)
            ->whereBetween('payments.created_at', $dateRange)
            ->join('users', 'payments.user_id', '=', 'users.id')
            ->select(
                DB::raw("$busIdExpression as bus_id"),
                DB::raw('SUM(payments.amount) as total'),
                DB::raw('COUNT(payments.id) as count')
            )
            ->groupBy('bus_id')
            ->get()
            ->keyBy('bus_id');

        $completed = $totalsFor('completed');
        $refunded = $totalsFor('refunded');

        $busIds = collect($busNames)->keys()
            ->merge($completed->keys())
            ->merge($refunded->keys())
            ->unique();

        return $busIds->map(function ($busId) use ($completed, $refunded, $busNames) {
            $paid = (float) ($completed[$busId]->total ?? 0);
            $refund = (float) ($refunded[$busId]->total ?? 0);

            return (object) [
                'bus_id' => $busId,
                'bus_name' => $busNames[$busId] ?? $busId,
                'total' => $paid - $refund,
                'count' => (int) ($completed[$busId]->count ?? 0),
                'refunded_count' => (int) ($refunded[$busId]->count ?? 0),
                'refunded_total' => $refund,
            ];
        })
            ->sortBy([['total', 'desc'], ['bus_name', 'asc']])
            ->values();
    }
}
