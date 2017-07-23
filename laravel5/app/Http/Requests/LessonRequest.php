<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LessonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'sometimes|required',
            'introduce' => 'sometimes|required',
            'preview' => 'sometimes|required',
            'click' => 'sometimes|integer',
        ];
    }
    /**
     * 获取已定义验证规则的错误消息。
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => '课程名称不能为空',
            'introduce.required' => '课程介绍不能为空',
            'preview.required' => '课程预览图不能为空',
            'click.integer' => '点击次数必须为数字',
        ];
    }
}
