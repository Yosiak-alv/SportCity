<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class CreateEditTrainingSessionRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'name' => ['required','string','max:255'],
            'description' => ['required','min:10','string','max:5000'],
            'duration' => ['required','numeric', 'gt:0','max:255'],
            'gym_id' => ['numeric','gt:0','exists:gyms,id'],
            'user_id' => ['numeric','gt:0','exists:users,id'],
            'starts_at' => ['required','date','regex:/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/'],
            'finish_at' => ['required','date','after:starts_at','regex:/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/'],

            'coach_id' => ['required','array'],
            'coach_id.*' => ['numeric','gt:0','exists:coaches,id'],

            'client_id' => ['required','array'],
            'client_id.*' => ['numeric','gt:0','exists:clients,id'],
            'attendance_date' => ['required','array'],
            /* 'attendance_date*' => ['date','after_or_equal:starts_at','before_or_equal:finish_at','regex:/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/'], */
            'attendance_date*' => ['date'],
            'exercise_id' => ['required','array'],
            'exercise_id.*' => ['numeric','gt:0','exists:exercises,id'],
            'repetitions' => ['required','array'],
            'repetitions*' => ['gt:0','numeric'],
        ];
    }
    public function validatedTrainingSession(): array
    {
        return $this->only('name','description','duration','starts_at','finish_at','gym_id','user_id');
    }
    public function validatedCoachIds()
    {
        return ($this->only('coach_id')['coach_id']);
    }
    public function validatedClientIds()
    {
        return collect($this->only('client_id')['client_id']);
    }
    public function validatedExerciseIds()
    {
        return collect($this->only('exercise_id')['exercise_id']);
    }
    public function validatedRepetitions()
    {
        return $this->only('repetitions')['repetitions'];
    }
    public function validatedAttendaceDates()
    {
        return $this->only('attendance_date')['attendance_date'];
    }
}
