<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_name',
        'user_email',
        'user_role',
        'action',
        'description',
        'model_type',
        'model_id',
        'ip_address',
        'user_agent',
        'browser',
        'platform',
        'device',
        'old_values',
        'new_values',
        'metadata',
        'url',
        'method',
        'referer',
        'session_id',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'metadata' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Log an activity
     */
    public static function log($action, $description, $modelType = null, $modelId = null, $additionalData = [])
    {
        $request = request();
        $user = auth()->user();
        
        // Parse user agent
        $userAgent = $request->userAgent();
        $browser = self::getBrowser($userAgent);
        $platform = self::getPlatform($userAgent);
        $device = self::getDevice($userAgent);
        
        $data = [
            'user_id' => $user ? $user->id : null,
            'user_name' => $user ? $user->name : 'Anonymous Visitor',
            'user_email' => $user ? $user->email : null,
            'user_role' => $user ? $user->role : 'visitor',
            'action' => $action,
            'description' => $description,
            'model_type' => $modelType,
            'model_id' => $modelId,
            'ip_address' => $request->ip(),
            'user_agent' => $userAgent,
            'browser' => $browser,
            'platform' => $platform,
            'device' => $device,
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'referer' => $request->header('referer'),
            'session_id' => session()->getId(),
        ];
        
        // Merge additional data
        return self::create(array_merge($data, $additionalData));
    }

    private static function getBrowser($userAgent)
    {
        if (strpos($userAgent, 'Chrome') !== false) return 'Chrome';
        if (strpos($userAgent, 'Safari') !== false) return 'Safari';
        if (strpos($userAgent, 'Firefox') !== false) return 'Firefox';
        if (strpos($userAgent, 'Edge') !== false) return 'Edge';
        if (strpos($userAgent, 'Opera') !== false) return 'Opera';
        return 'Unknown';
    }

    private static function getPlatform($userAgent)
    {
        if (strpos($userAgent, 'Windows') !== false) return 'Windows';
        if (strpos($userAgent, 'Mac') !== false) return 'MacOS';
        if (strpos($userAgent, 'Linux') !== false) return 'Linux';
        if (strpos($userAgent, 'Android') !== false) return 'Android';
        if (strpos($userAgent, 'iPhone') !== false || strpos($userAgent, 'iPad') !== false) return 'iOS';
        return 'Unknown';
    }

    private static function getDevice($userAgent)
    {
        if (strpos($userAgent, 'Mobile') !== false) return 'mobile';
        if (strpos($userAgent, 'Tablet') !== false || strpos($userAgent, 'iPad') !== false) return 'tablet';
        return 'desktop';
    }
}