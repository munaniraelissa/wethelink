@extends('dashboard.layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>Message Details</h2>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ route('dashboard.contact-messages.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Messages
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">{{ $message->subject }}</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong>From:</strong> {{ $message->name }}
                            </p>
                            <p class="mb-0">
                                <strong>Email:</strong> <a href="mailto:{{ $message->email }}">{{ $message->email }}</a>
                            </p>
                        </div>
                        <div class="col-md-6 text-right">
                            <p class="mb-2">
                                <strong>Date:</strong> {{ $message->created_at->format('M d, Y') }}
                            </p>
                            <p class="mb-0">
                                <strong>Time:</strong> {{ $message->created_at->format('H:i') }}
                            </p>
                        </div>
                    </div>

                    <hr>

                    <div class="message-content">
                        <h6 class="mb-3">Message:</h6>
                        <p class="bg-light p-4 border-left-primary" style="border-left: 4px solid #0d6efd;">
                            {!! nl2br(e($message->message)) !!}
                        </p>
                    </div>
                </div>
                <div class="card-footer bg-light">
                    <a href="mailto:{{ $message->email }}?subject=Re: {{ urlencode($message->subject) }}" class="btn btn-primary">
                        <i class="fas fa-reply"></i> Reply
                    </a>
                    <form action="{{ route('dashboard.contact-messages.destroy', $message) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?');">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Message Info</h5>
                </div>
                <div class="card-body">
                    <p class="mb-3">
                        <strong>Status:</strong> <br>
                        @if($message->is_read)
                            <span class="badge bg-secondary">Read</span>
                        @else
                            <span class="badge bg-danger">Unread</span>
                        @endif
                    </p>
                    <p class="mb-3">
                        <strong>Received:</strong> <br>
                        <small class="text-muted">{{ $message->created_at->diffForHumans() }}</small>
                    </p>
                    <hr>
                    <p class="mb-0">
                        <strong>Sender Details:</strong><br>
                        <small>
                            {{ $message->name }}<br>
                            <a href="mailto:{{ $message->email }}" class="text-primary">{{ $message->email }}</a>
                        </small>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
