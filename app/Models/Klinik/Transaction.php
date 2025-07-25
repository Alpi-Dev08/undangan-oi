<?php

namespace App\Models\Klinik;

use App\Core\Traits\SpatieLogsActivity;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Transaction extends Model
{
    use SpatieLogsActivity, HasFactory, SoftDeletes;

    protected $fillable = [
        'examination_id',
        'invoice_number',
        'amount',
        'notes',
        'status',
        'metode_pembayaran',
        'payment_confirmation_user_id',
        'created_by',
        'updated_by'
    ];

    /**
     * Boot method untuk mengatur created_by dan updated_by otomatis
     */
    protected static function boot()
    {
        parent::boot();

        // Set created_by saat record dibuat
        static::creating(function ($model) {
            if (Auth::check()) {
                $model->created_by = Auth::id();
                $model->updated_by = Auth::id();
                Log::info('Transaction created by user: ' . Auth::id());
            }
        });

        // Set updated_by saat record diupdate
        static::updating(function ($model) {
            if (Auth::check()) {
                $model->updated_by = Auth::id();
                Log::info('Transaction updated by user: ' . Auth::id());
            }
        });
    }

    /**
     * Relasi ke transaction details
     *
     * @return HasMany
     */
    public function transactionDetails(): HasMany
    {
        return $this->hasMany(TransactionDetail::class);
    }

    /**
     * Relasi ke examination
     *
     * @return BelongsTo
     */
    public function examination(): BelongsTo
    {
        return $this->belongsTo(Examination::class);
    }

    /**
     * Relasi ke user yang mengkonfirmasi pembayaran
     *
     * @return BelongsTo
     */
    public function paymentConfirmationUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'payment_confirmation_user_id');
    }

    /**
     * Relasi ke user yang membuat record
     *
     * @return BelongsTo
     */
    public function createdByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relasi ke user yang terakhir mengupdate record
     *
     * @return BelongsTo
     */
    public function updatedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Method untuk mengkonfirmasi pembayaran
     *
     * @param int|null $userId
     * @return bool
     */
    public function confirmPayment($userId = null): bool
    {
        try {
            $this->payment_confirmation_user_id = $userId ?? Auth::id();
            $this->status = 'paid';
            $saved = $this->save();

            if ($saved) {
                Log::info('Payment confirmed for transaction: ' . $this->id . ' by user: ' . $this->payment_confirmation_user_id);
            }

            return $saved;
        } catch (\Exception $e) {
            Log::error('Error confirming payment for transaction: ' . $this->id . ' - ' . $e->getMessage());
            return false;
        }
    }
}
