<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KuisRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        $input = $this->all();

        foreach ($input['questions'] as &$question) {
            foreach ($question['options'] as &$option) {
                if (isset($option['is_correct']) && is_array($option['is_correct'])) {
                    $option['is_correct'] = $option['is_correct'][0]; // ambil nilainya
                }
            }
        }

        $this->replace($input);
        return [
            'rps_detail_id' => 'required|integer',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'questions' => 'required|array|min:1',
            'questions.*.question_text' => 'required|string|max:255',
            'questions.*.options' => 'required|array|min:1',
            'questions.*.options.*.option_text' => 'required|string|max:255',
            'questions.*.options.*.is_correct' => 'nullable|in:0,1',
        ];
    }

    public function messages()
    {
        return [
            'questions.*.options.*.option_text.required' => 'Setiap jawaban harus diisi.',
            'questions.*.options.*.is_correct.boolean' => 'Status jawaban benar harus berupa true atau false.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $questions = $this->input('questions', []);

            foreach ($questions as $index => $question) {
                $hasCorrect = false;

                foreach ($question['options'] as $option) {
                    if (isset($option['is_correct']) && $option['is_correct']) {
                        $hasCorrect = true;
                        break;
                    }
                }

                if (! $hasCorrect) {
                    $validator->errors()->add("questions.$index.options", "Minimal satu jawaban harus ditandai sebagai benar pada soal ke-" . ($index + 1));
                }
            }
        });
    }
}
