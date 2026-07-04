@extends('dashboard.layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>Contact Messages</h2>
            <p class="text-muted">Manage messages from your contact form</p>
        </div>
        <div class="col-md-4 text-right">
            @if($unreadCount > 0)
                <span class="badge badge-danger" style="font-size: 1em; padding: 8px 12px;">
                    {{ $unreadCount }} Unread
                </span>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>Status</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($messages as $message)
                        <tr class="{{ !$message->is_read ? 'table-active' : '' }}">
                            <td>
                                @if(!$message->is_read)
                                    <span class="badge bg-danger">New</span>
                                @else
                                    <span class="badge bg-secondary">Read</span>
                                @endif
                            </td>
                            <td>{{ $message->name }}</td>
                            <td>{{ $message->email }}</td>
                            <td>{{ Str::limit($message->subject, 50) }}</td>
                            <td>{{ $message->created_at->format('M d, Y H:i') }}</td>
                            <td>
                                <a href="{{ route('dashboard.contact-messages.show', $message) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <form action="{{ route('dashboard.contact-messages.destroy', $message) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <p class="text-muted mb-0">No contact messages found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($messages->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $messages->links() }}
        </div>
    @endif
</div>
@endsection
