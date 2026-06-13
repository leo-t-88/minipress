<?php
declare(strict_types=1);

namespace mp\core\domain\entities;
use Illuminate\Database\Eloquent as Eloq;

class Article extends Eloq\Model{
    protected $table = "Article";
    protected $primaryKey = "id";
    public $timestamps = false;

    public function auteur()
    {
        return $this->belongsTo(User::class, "auteur_id");
    }

    public function categorie()
    {
        return $this->belongsTo(Categorie::class, "categorie_id");
    }
}
