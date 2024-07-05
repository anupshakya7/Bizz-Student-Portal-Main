<?php

namespace App\Models\CRM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentRecordCRM extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';
    protected $table = 'tbl_multiple_country';
}
