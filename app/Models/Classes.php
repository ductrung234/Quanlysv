<?php
// app/Models/Classes.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;

    protected $table = 'classes';
    
    protected $fillable = [
        'class_code',
        'class_name',
        'teacher_name',
        'max_students',
        'description',
        'room'
    ];
}