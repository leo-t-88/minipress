<?php
declare(strict_types=1);

namespace mp\core\domain\entities;
use Illuminate\Database\Eloquent as Eloq;

class Image extends Eloq\Model{
    protected $table = "Image";
    protected $primaryKey = "id";
    public $timestamps = false;

    public function article()
    {
        return $this->belongsTo(Article::class, "article_id");
    }
}
