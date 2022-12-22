@extends('layouts.master')
{{-- set page title --}}
@section('title', 'Thêm mới task')

@section('content')
    <form action="{{ route('tasks.store') }}" method="POST"> 

        @csrf
        
        <input type="text" name="name" value="">
        
        <input type="submit" value="Submit">
    
    </form>
@endsection