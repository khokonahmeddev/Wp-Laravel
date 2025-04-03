@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form method="GET" action="{{ route('home') }}" class="d-flex">
                            <input class="form-control me-2 w-40" type="text" placeholder="Search"
                                   aria-label="Search" name="search">
                            <select class="form-control w-40 me-2" name="position">
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

                            <input class="form-control me-2 w-40" type="date" placeholder="Search"
                                   aria-label="Search" name="form_date">

                            <input class="form-control me-2 w-40" type="date" placeholder="Search"
                                   aria-label="Search" name="to_date">

                            <button type="submit" class="btn btn-primary w-15">Filter</button>
                        </form>

                        <table class="table">
                            <thead>
                            <tr>
                                <th>SL</th>
                                <th>Full Name</th>
                                <th>Position</th>
                                <th>Phone Number</th>
                                <th>Other Phone Number</th>
                                <th>Email</th>
                                <th>Portfolio/Facebook link</th>
                                <th>Present Address</th>
                                <th>Cover Letter or Message</th>
                                <th>Preview</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($entries as $key => $entry)
                                @php
                                    $fields = json_decode($entry->fields);
                                @endphp
                                <tr>
                                    <td>{{$key + 1}}</td>
                                    <td>{{ $fields->{1}->value ?? 'N/A' }}</td>
                                    <td>{{ $fields->{2}->value ?? 'N/A' }}</td>
                                    <td>{{ $fields->{9}->value ?? 'N/A' }}</td>
                                    <td>{{ $fields->{16}->value ?? 'N/A' }}</td>
                                    <td>{{ $fields->{5}->value ?? 'N/A' }}</td>
                                    <td>{{ $fields->{6}->value ?? 'N/A' }}</td>
                                    <td>{{ $fields->{11}->value ?? 'N/A' }}</td>
                                    <td>{{ $fields->{12}->value ?? 'N/A' }}</td>
                                    <td>
                                        @if(!empty($fields->{13}->value))
                                            <a href="{{ $fields->{13}->value }}" target="_blank">Preview CV</a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('entry.comment', $entry->entry_id) }}" class="btn btn-info">Comment</a>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
