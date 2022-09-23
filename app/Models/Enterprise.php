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

class Enterprise extends Model implements HasMedia
{
    use SoftDeletes;
    use MultiTenantModelTrait;
    use InteractsWithMedia;
    use Auditable;
    use HasFactory;

    public const SKALA_USAHA_SELECT = [
        'mikro'    => 'Mikro',
        'kecil'    => 'Kecil',
        'menengah' => 'Menengah',
    ];

    public $table = 'enterprises';

    public static $searchable = [
        'nib',
        'alamat',
        'description',
    ];

    protected $appends = [
        'gallery',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'nib',
        'is_nib_valid',
        'name',
        'skala_usaha',
        'alamat',
        'jenis_usaha_id',
        'pemilik_id',
        'description',
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

    public function umkmPenyediaTimeProjects()
    {
        return $this->hasMany(TimeProject::class, 'umkm_penyedia_id', 'id');
    }

    public function umkmPenerimaTimeProjects()
    {
        return $this->hasMany(TimeProject::class, 'umkm_penerima_id', 'id');
    }

    public function umkmEnterpriseDocs()
    {
        return $this->hasMany(EnterpriseDoc::class, 'umkm_id', 'id');
    }

    public function jenis_usaha()
    {
        return $this->belongsTo(TypeOfBusiness::class, 'jenis_usaha_id');
    }

    public function pemilik()
    {
        return $this->belongsTo(User::class, 'pemilik_id');
    }

    public function getGalleryAttribute()
    {
        $files = $this->getMedia('gallery');
        $files->each(function ($item) {
            $item->url = $item->getUrl();
            $item->thumbnail = $item->getUrl('thumb');
            $item->preview = $item->getUrl('preview');
        });

        return $files;
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
