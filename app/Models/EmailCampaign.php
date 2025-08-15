<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailCampaign extends Model
{
    /** @use HasFactory<\Database\Factories\EmailCampaignFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'subject',
        'content',
        'template',
        'sender_name',
        'sender_email',
        'recipient_list',
        'status',
        'scheduled_at',
        'sent_at',
        'total_recipients',
        'delivered_count',
        'opened_count',
        'clicked_count',
        'bounced_count',
        'unsubscribed_count',
    ];

    protected $casts = [
        'recipient_list' => 'array',
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
        'total_recipients' => 'integer',
        'delivered_count' => 'integer',
        'opened_count' => 'integer',
        'clicked_count' => 'integer',
        'bounced_count' => 'integer',
        'unsubscribed_count' => 'integer',
    ];

    /**
     * Get the open rate for the campaign.
     */
    public function getOpenRateAttribute()
    {
        if ($this->delivered_count == 0) {
            return 0;
        }

        return round(($this->opened_count / $this->delivered_count) * 100, 2);
    }

    /**
     * Get the click rate for the campaign.
     */
    public function getClickRateAttribute()
    {
        if ($this->delivered_count == 0) {
            return 0;
        }

        return round(($this->clicked_count / $this->delivered_count) * 100, 2);
    }
}
