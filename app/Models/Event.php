<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'event_category',
        'is_important',
        'planned_date',
        'planned_time',
        'max_participants',
        'location',
        'event_cost',
        'image_path',
        'video_path',
    ];

    /**
     * medias
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function medias()
    {
        return $this->hasMany(EventMedia::class);
    }

    /**
     * announcements
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function announcements()
    {
        return $this->hasMany(EventAnnouncement::class);
    }
    
    /**
     * activities
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    /**
     * Store the uploaded image in the public/storage directory and return its path.
     */
    public function storeImage($image)
    {
        if ($image && $image->isValid() && in_array($image->extension(), ['jpg', 'jpeg', 'png', 'gif'])) {
            $path = 'uploads/images/events';
            $imageName = uniqid() . '.' . $image->extension();
            $image->move(public_path($path), $imageName);
            return $path . '/' . $imageName;
        }

        throw new \Exception('Invalid image file.');
    }

    /**
     * Store the uploaded video in the public/storage directory and return its path.
     */
    public function storeVideo($video)
    {
        if ($video && $video->isValid() && in_array($video->extension(), ['mp4', 'avi', 'mov', 'mkv'])) {
            $path = 'uploads/videos/events';
            $videoName = uniqid() . '.' . $video->extension();
            $video->move(public_path($path), $videoName);
            return $path . '/' . $videoName;
        }

        throw new \Exception('Invalid video file.');
    }

    /**
     * Delete the stored image file from the public/storage directory.
     */
    public function deleteImage()
    {
        if ($this->image_path && file_exists(public_path($this->image_path))) {
            unlink(public_path($this->image_path));
        }
    }

    /**
     * Delete the stored video file from the public/storage directory.
     */
    public function deleteVideo()
    {
        if ($this->video_path && file_exists(public_path($this->video_path))) {
            unlink(public_path($this->video_path));
        }
    }
}
