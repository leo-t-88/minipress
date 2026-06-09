<?php
declare(strict_types=1);

namespace minipress\core\domain\entities;
use \Illuminate\Database\Eloquent as Eloq;

class User extends Eloq\Model {
      protected $table = 'User';
      protected $primaryKey = 'id';
      public $timestamps = false;

      public function articles() {
            return $this->hasMany(Article::class, 'auteur_id');
      }
}
