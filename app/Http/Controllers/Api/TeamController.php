<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeamController extends Controller
{
    private function getLegTree($parentId, $site)
    {
        return DB::select("
            WITH RECURSIVE tree AS (
                SELECT id, investment_balance
                FROM clients
                WHERE ref_id = ? AND site = ?

                UNION ALL

                SELECT c.id, c.investment_balance
                FROM clients c
                INNER JOIN tree t ON c.ref_id = t.id
            )
            SELECT id, investment_balance
            FROM tree
        ", [$parentId, $site]);
    }

    private function getLegData($parentId, $site)
    {
        $result = DB::select("
            WITH RECURSIVE tree AS (
                SELECT id, investment_balance
                FROM clients
                WHERE ref_id = ? AND site = ?

                UNION ALL

                SELECT c.id, c.investment_balance
                FROM clients c
                INNER JOIN tree t ON c.ref_id = t.id
            )
            SELECT
                COUNT(*) AS total,
                COALESCE(SUM(investment_balance),0) AS balance
            FROM tree
        ", [$parentId, $site]);

        return [
            'count' => $result[0]->total ?? 0,
            'balance' => $result[0]->balance ?? 0,
        ];
    }

    public function summary(Request $request)
    {
        $id = $request->id;

        $client = Client::findOrFail($id);

        $leftTree = $this->getLegTree($id, 0);
        $rightTree = $this->getLegTree($id, 1);

        $leftData = $this->getLegData($id, 0);
        $rightData = $this->getLegData($id, 1);

        return response()->json([
            'team_a' => $leftData['count'],
            'team_b' => $rightData['count'],
            'total' => $leftData['count'] + $rightData['count'],

            'left_balance' => $leftData['balance'],
            'right_balance' => $rightData['balance'],

            'total_balance' => number_format($leftData['balance'] + $rightData['balance'], 2),

            'left_tree' => $leftTree,
            'right_tree' => $rightTree,
        ]);
    }
}