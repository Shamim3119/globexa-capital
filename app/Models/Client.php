<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
                            'name', 
                            'address', 
                            'phone', 
                            'email', 
                            'inactive',
                            'password',
                            'left_side',
                            'right_side',
                            'ref_id',
                            'site',
                            'photo',
                            'level',
                            'otp',
                            'income_balance',
                            'deposit_balance',
                            'investment_balance',


                            'first_name',
                            'last_nanme',
                            'date_of_birth',
                            'verification_address',
                            'post_code',
                            'city',
                            'doc_type',
                            'doc_img',
                            'verification_status',

                        ];


    public function parent()
    {
        return $this->belongsTo(Client::class, 'ref_id');
    }


 protected $table = 'clients';

    public function investments()
    {
        return $this->hasMany(Investment::class, 'client_id');
    }

    public function getLegClientIds($site)
    {
        $directChildren = self::where('ref_id', $this->id)
            ->where('site', $site)
            ->pluck('id');

        $allIds = collect($directChildren);

        foreach ($directChildren as $childId) {
            $child = self::find($childId);
            if ($child) {
                $allIds = $allIds->merge($child->getLegClientIds(0))
                                 ->merge($child->getLegClientIds(1));
            }
        }

        return $allIds->unique();
    }

    /**
     * Calculate total investment balance with filters
     */
    public function getLegInvestmentBalance($site, $startDate = null, $endDate = null, $inactive = -1, $filterClientId = null)
    {
        $clientIds = $this->getLegClientIds($site);

        if ($clientIds->isEmpty()) {
            return 0.00;
        }

        // Base query for investments within the network leg clients
        $query = Investment::whereIn('client_id', $clientIds);

        // 1. Filter by specific client_id if provided
        if (!empty($filterClientId)) {
            // Ensure the requested client is actually part of this leg's downline
            if (!$clientIds->contains($filterClientId)) {
                return 0.00; // Client not in this leg
            }
            $query->where('client_id', $filterClientId);
        }

        // 2. Filter by date range (compared with investments created_at)
        if (!empty($startDate)) {
            $query->whereDate('created_at', '>=', $startDate);
        }
        if (!empty($endDate)) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        // 3. Filter by inactive status (-1 means All)
        if ($inactive !== -1 && $inactive !== '-1' && $inactive !== null) {
            $query->where('inactive', $inactive);
        }

        return $query->sum('amount');
    }
}