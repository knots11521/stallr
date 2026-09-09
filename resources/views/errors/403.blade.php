@extends('layouts.guest')

@section('title', '403 - Access Denied')

@section('content')
    <x-error-display code="403"
        title="Access Restricted"
        message="You do not have permission to access this page. Please sign in with an authorized account or contact support."
        action-text="Sign In"
        action-href="{{ route('login') }}" />
@endsection
