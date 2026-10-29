@extends('admin.layout.app')

@section('title', 'Manage Posts')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manage Posts</h1>
        <a href="{{ route('posts.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create New Post
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Posts</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="postsTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Likes</th>
                            <th>Comments</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($posts as $post)
                        <tr>
                            <td>{{ $post->id }}</td>
                            <td>{{ Str::limit($post->title, 50) }}</td>
                            <td>{{ $post->user->name ?? 'N/A' }}</td>
                            <td>
                                <span class="badge badge-{{ $post->type === 'news' ? 'info' : ($post->type === 'result' ? 'success' : 'warning') }}">
                                    {{ ucfirst($post->type) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-{{ $post->is_published ? 'success' : 'secondary' }}">
                                    {{ $post->is_published ? 'Published' : 'Draft' }}
                                </span>
                            </td>
                            <td>{{ $post->likes_count ?? 0 }}</td>
                            <td>{{ $post->comments_count ?? 0 }}</td>
                            <td>{{ $post->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('posts.show', $post->id) }}" class="btn btn-sm btn-info" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this post?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">No posts found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#postsTable').DataTable({
            "order": [[0, "desc"]]
        });
    });
</script>
@endsection
