<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
    use HasFactory;

    protected $table = 'contacts';

    protected $fillable = [
        'name',
        'number',
        'email',
        'id'
    ];

    public $timestamps = false;

    public function json(){
        return [
            "name"      => $this->name,
            "numbers"   => $this->number,
            "email"     => $this->email
        ];
    }

    
}

?>
