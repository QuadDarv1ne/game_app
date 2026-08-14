<?php

namespace App\Http\Requests\Comment;

use App\Models\Comment;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $comment = $this->route('comment');

        $commentId = $comment instanceof Comment ? $comment->id : null;

        return [
            'post_id' => $commentId ? 'nullable|exists:posts,id' : 'required|exists:posts,id',
            'content' => 'required|string|max:1000',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'user_id' => auth()->user()->id,
        ]);
    }
}
