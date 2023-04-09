<?php

namespace App\Http\Requests;

use App\Rules\validateThreePostsMaxPerUser;
use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|min:3|unique:posts,title',
            'description' => 'required|min:10|max:225',
//            'posted_by' => 'required|exists:users,id|three_posts_max_per_user',
//            'posted_by' => ['required', 'exists:users,id', new validateThreePostsMaxPerUser],
            'posted_by' => ['required', 'exists:users,id'],
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',

        ];
    }
    public function messages(): array
    {
        return [
            'title.required' => 'Post Title is Required',
            'title.unique' => 'Post Title Already exists',
            'title.min' => 'Title must be more than 3 characters',
            'description.required' => 'Post Description is required',
            'description.min' => 'Description Must be more than 10 character',
            'description.max' => 'Description cannot exceed 225 character',
            'posted_by.required' => 'Select User',
            'description.exists' => 'Invalid User ID',
        ];
    }
}
