@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Setup Security Question</h1>
    <form action="{{ route('password.setup-security-question') }}" method="POST">
        @csrf
        <!-- Your form fields for security question setup -->
        <button type="submit">Submit</button>
    </form>
</div>
@endsection 