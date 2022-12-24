<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // chuyển return false thành true
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
            //name tương đương với name input
            'name'=>'required|min:5|max:50',
            'user_id'=>'required|exists:users,id',
            // exitsts:user_id, id đây là rule dùng để kiểm tra
            // xem giá trị của input name ="user_id" gửi lên có tồn tại trong table users
            // rule image: yêu cầu người dùng gửi lên phải là hình ảnh
            // rule mimes:jpg,bmp,png: yêu cầu gửi lên phải có đuôi jpg,bmp,png
            'image'=>'nullable|image|mimes:jpg,bmp,png,jfif'
        ];
    }
}
