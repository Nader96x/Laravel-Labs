<?php

namespace App\Rules;

use App\Models\Post;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;


class validateThreePostsMaxPerUser implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $posts = Post::where('user_id', $value)->get();
        if ($posts->count() >= 3) {
            $fail('User can only have 3 posts he has now '.$posts->count().' posts');

        }
    }
}
