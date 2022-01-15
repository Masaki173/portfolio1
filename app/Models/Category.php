<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'category_id';
    protected $fillable = ['name', 'display_order'];
    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    public function getCategoryList(int $num_per_page = 0, string $order = 'display_order', string $direction = 'asc')
    {
        $query = $this->orderBy($order, $direction);
        if ($num_per_page) {
            return $query->paginate($num_per_page);
        }
        return $query->get();
    }
}
