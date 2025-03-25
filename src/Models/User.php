<?php

namespace Source\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    // Use the HasFactory trait for creating factories (useful for testing and seeding)
    use HasFactory;

    // Define the table associated with this model
    protected $table = 'users';

    // Define the attributes that can be mass-assigned (e.g., through create() or update())
    protected $fillable = ['name', 'email', 'password'];

    // Define attributes that should be hidden when the model is converted to an array or JSON
    // In this case, the password will be hidden to protect sensitive data
    protected $hidden = ['password'];

    /**
     * Define the relationship between User and Post
     * A User can have many Posts
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts(): HasMany
    {
        // Return the relationship: a User has many Posts
        return $this->hasMany(Post::class);
    }
}
