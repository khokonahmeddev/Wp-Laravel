@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Comments</h5>
                    </div>

                    <div class="card-body">
                        {{-- Display Validation Errors --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="post" action="{{ route('comment.store', $id) }}" class="d-flex flex-column gap-3">
                            @csrf
                            <div>
                                <textarea name="comment" class="form-control"
                                          placeholder="Write your comment...">

                                </textarea>

                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary px-4">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="mt-4">
                    @forelse ($comments as $comment)
                        <div class="card mb-3 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-2">
                                    <h6 class="mb-0 fw-bold text-primary">
                                        {{ $comment->user->name ?? 'Unknown User' }} {{-- Display user name --}}
                                    </h6>
                                </div>
                                <p class="mb-0 text-muted">
                                    {{ $comment->body }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-muted">No comments yet</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
