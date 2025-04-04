@extends('layouts.app')

@section('content')
    <div class="container-fluid mt-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Career Submissions</h4>
            </div>
            <div class="card-body">
                <!-- Filter Form -->
                <form method="GET" action="{{ route('home') }}" class="row g-3 mb-3">
                    <div class="col-md-3">
                        <input class="form-control" type="text" placeholder="Search..." name="search">
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="position">
                            <option value="">Choose a position</option>
                            <option value="Software Engineer">Software Engineer</option>
                            <option value="Sales & Marketing Executive">Sales & Marketing Executive</option>
                            <option value="Web Developer">Web Developer</option>
                            <option value="WordPress Developer">WordPress Developer</option>
                            <option value="Marketing Manager">Marketing Manager</option>
                            <option value="Digital Marketer">Digital Marketer</option>
                            <option value="Graphic Designer">Graphic Designer</option>
                            <option value="UI/UX Designer">UI/UX Designer</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input class="form-control" type="date" name="form_date">
                    </div>
                    <div class="col-md-2">
                        <input class="form-control" type="date" name="to_date">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-dark w-100">Filter</button>
                    </div>
                </form>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Position</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Portfolio</th>
                            <th>Address</th>
                            <th>Message</th>
                            <th>Resume</th>
                            <th>Submitted On</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($submissions as $key => $submission)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $submission->id }}</td>
                                <td>{{ optional($submission->values->firstWhere('key', 'field_8e5167f'))->value ?? 'N/A' }}</td>
                                <td>{{ optional($submission->values->firstWhere('key', 'field_6d78971'))->value ?? 'N/A' }}</td>
                                <td>{{ optional($submission->values->firstWhere('key', 'name'))->value ?? 'N/A' }}</td>
                                <td>{{ optional($submission->values->firstWhere('key', 'email'))->value ?? 'N/A' }}</td>
                                <td>
                                    @if($portfolio = optional($submission->values->firstWhere('key', 'field_342a80e'))->value)
                                        <a href="{{ $portfolio }}" target="_blank"
                                           class="btn btn-outline-primary btn-sm">View</a>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{ optional($submission->values->firstWhere('key', 'field_60527fe'))->value ?? 'N/A' }}</td>

                                <!-- Message Column with "See More" Feature -->
                                <td>
                                    @php
                                        $message = optional($submission->values->firstWhere('key', 'message'))->value ?? 'N/A';
                                        $shortMessage = \Illuminate\Support\Str::limit($message, 50);
                                    @endphp

                                    <span id="short-text-{{ $submission->id }}">{{ $shortMessage }}</span>
                                    <span id="full-text-{{ $submission->id }}"
                                          style="display: none;">{{ $message }}</span>

                                    @if(strlen($message) > 50)
                                        <a href="javascript:void(0);" onclick="toggleText({{ $submission->id }})"
                                           id="toggle-btn-{{ $submission->id }}" class="text-primary">See more</a>
                                    @endif
                                </td>

                                <td>
                                    @if($resume = optional($submission->values->firstWhere('key', 'field_916cb66'))->value)
                                        <a href="https://docs.google.com/viewer?url={{ urlencode($resume) }}&embedded=true"
                                           target="_blank" class="btn btn-outline-primary btn-sm">Preview</a>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($submission->created_at)->format('Y-m-d') }}</td>
                                <td>
                                    <a href="{{ route('comment.view', $submission->id) }}"
                                       class="btn btn-{{ $submission->total_comments ? 'success' : 'info' }} btn-sm">Comment</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $submissions->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

@endsection

<!-- JavaScript to Toggle "See More" -->
@section('scripts')
    <script>
        function toggleText(id) {
            let shortText = document.getElementById('short-text-' + id);
            let fullText = document.getElementById('full-text-' + id);
            let toggleBtn = document.getElementById('toggle-btn-' + id);

            if (shortText.style.display === 'none') {
                shortText.style.display = 'inline';
                fullText.style.display = 'none';
                toggleBtn.innerText = 'See more';
            } else {
                shortText.style.display = 'none';
                fullText.style.display = 'inline';
                toggleBtn.innerText = 'See less';
            }
        }
    </script>
@endsection
