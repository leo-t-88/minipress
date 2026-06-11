<?php
declare(strict_types=1);

namespace mp\core\domain\entities;
use Illuminate\Database\Eloquent as Eloq;

class Categorie extends Eloq\Model {
    protected $table = "Categorie";
    protected $primaryKey = "id";
    public $timestamps = false;

    public function articles()
    {
        return $this->hasMany(Article::class, "categorie_id");
    }

}
