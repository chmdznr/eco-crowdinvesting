<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use App\Traits\MultiTenantModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class TimeProject extends Model implements HasMedia
{
    use SoftDeletes;
    use MultiTenantModelTrait;
    use InteractsWithMedia;
    use Auditable;
    use HasFactory;

    public $table = 'time_projects';

    public static $searchable = [
        'code',
        'description',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'code',
        'name',
        'umkm_penyedia_id',
        'umkm_penerima_id',
        'mode_investasi_id',
        'mode_pembayaran_id',
        'biaya_diajukan',
        'biaya_terpenuhi',
        'remote_device',
        'description',
        'status_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by_id',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function projectProjectDocs()
    {
        return $this->hasMany(ProjectDoc::class, 'project_id', 'id');
    }

    public function projectTasks()
    {
        return $this->hasMany(Task::class, 'project_id', 'id');
    }

    public function umkm_penyedia()
    {
        return $this->belongsTo(Enterprise::class, 'umkm_penyedia_id');
    }

    public function umkm_penerima()
    {
        return $this->belongsTo(Enterprise::class, 'umkm_penerima_id');
    }

    public function investors()
    {
        return $this->belongsToMany(User::class);
    }

    public function mode_investasi()
    {
        return $this->belongsTo(FinancialAccessType::class, 'mode_investasi_id');
    }

    public function mode_pembayaran()
    {
        return $this->belongsTo(MarketAccessType::class, 'mode_pembayaran_id');
    }

    public function status()
    {
        return $this->belongsTo(ProjectStatus::class, 'status_id');
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
