@extends('layouts.master')
{{-- set page title --}}
@section('title', 'sửa task')
@section('content')
    <form action="{{ route('tasks.update',['id'=>10])}}" method="POST"> 

        @csrf
        @method('PUT')
        
        <input type="text" name="name" value="abc">
        
        <input type="submit" value="Update">
    
    </form>
@endsection