@extends('layouts.master')
{{-- set page title --}}
@section('title', 'Thêm mới task')

@section('content')
    <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data"> 

        @csrf
        {{-- old('name') được dùng để hiển thị lại giá trị cũ đã nhập trước đó (khi submit form thì gặp lỗi thì nó quay lại Form hiện tại và hiển thị giá trị đã nhập) --}}
        <div class="md-5">
            <label for="">Task Name(*)</label>
            <input type="text" name="name" value="{{ old('name')}}" class="form-control">
            @error('name')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
           
        <div class="md-5">
            <label for="">User</label>
            <select name="user_id" class="form-control">
                @foreach($users as $key => $value)
                <option value="{{ $key }}"
                {{ old('user_id') == $key ? ' selected="selected"' : '' }}>{{ $value }}</option>
                @endforeach;
            </select>
            @error('user_id')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="md-5">
            <label for="">Task Image(*)</label>
            <input type="file" name="image" class="form-control">
            @error('image')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <input type="submit" value="Submit">
    
    </form>
@endsection