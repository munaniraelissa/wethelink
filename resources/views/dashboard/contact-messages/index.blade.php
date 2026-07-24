@extends('dashboard.app')

@section('content')
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>{{ __('dashboard.contact_messages.title') }}</h2>
            <p class="text-muted">{{ __('dashboard.contact_messages.description') }}</p>
        </div>
        <div class="col-md-4 text-right">
            @if($unreadCount > 0)
                <span class="badge badge-danger" style="font-size: 1em; padding: 8px 12px;">
                    {{ $unreadCount }} {{ __('dashboard.contact_messages.unread') }}
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
                        <th>{{ __('dashboard.contact_messages.status') }}</th>
                        <th>{{ __('dashboard.contact_messages.name') }}</th>
                        <th>{{ __('dashboard.contact_messages.email') }}</th>
                        <th>{{ __('dashboard.contact_messages.subject') }}</th>
                        <th>{{ __('dashboard.contact_messages.date') }}</th>
                        <th>{{ __('dashboard.contact_messages.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($messages as $message)
                        <tr class="{{ !$message->is_read ? 'table-active' : '' }}">
                            <td>
                                @if(!$message->is_read)
                                    <span class="badge bg-danger">{{ __('dashboard.contact_messages.new') }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ __('dashboard.contact_messages.read') }}</span>
                                @endif
                            </td>
                            <td>{{ $message->name }}</td>
                            <td>{{ $message->email }}</td>
                            <td>{{ Str::limit($message->subject, 50) }}</td>
                            <td>{{ $message->created_at?->format('M d, Y H:i') }}</td>
                            <td>
                                <a href="{{ route('dashboard.contact-messages.show', $message) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i> {{ __('dashboard.contact_messages.view') }}
                                </a>
                                <form action="{{ route('dashboard.contact-messages.destroy', $message) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('{{ __('dashboard.contact_messages.confirm_delete') }}');">
                                        <i class="fas fa-trash"></i> {{ __('dashboard.contact_messages.delete') }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <p class="text-muted mb-0">{{ __('dashboard.contact_messages.no_messages') }}</p>
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
