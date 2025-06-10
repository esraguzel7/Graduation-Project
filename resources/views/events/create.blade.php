@extends('main')

@php
    $page = 'Create New Event';

    $breadcrumb = [
        'Events' => '',
        'Create New Event',
    ];
@endphp

@section('content')

    <form action="{{ route('events.create.perform') }}" method="POST" enctype="multipart/form-data" class="ajax-form">
        <div class="card card-form">
            <div class="row no-gutters">
                <div class="col-lg-4 card-body">
                    <p><strong class="headings-color">Upload an Event Image or Video</strong></p>
                    <p class="text-muted">Please upload an image or video that represents the event. You can drag and drop
                        your files or click to select them. The first uploaded image will be used as the default poster for
                        the event.</p>
                </div>
                <div class="col-lg-8 card-form__body card-body d-flex align-items-center">

                    <div class="dropzone dropzone-multiple w-100" data-toggle="dropzone" data-dropzone-multiple
                        data-dropzone-url="{{ route('events.uploadMedia') }}" data-dropzone-files=''>

                        <div class="fallback">
                            <div class="custom-file">
                                <input type="file" name="medias" class="custom-file-input" id="form_medias" multiple>
                                <label class="custom-file-label" for="form_medias">Choose file</label>
                            </div>
                        </div>

                        <ul class="dz-preview dz-preview-multiple list-group list-group-flush">
                            <li class="list-group-item">
                                <div class="form-row align-items-center">
                                    <div class="col-auto">
                                        <div class="avatar">
                                            <img src="assets/images/avatar/blue.svg" class="avatar-img rounded" alt="..."
                                                data-dz-thumbnail>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="font-weight-bold" data-dz-name>...</div>
                                        <p class="small text-muted mb-0" data-dz-size>...</p>
                                    </div>
                                    <div class="col-auto">
                                        <a href="#" class="text-muted-light" data-dz-remove>
                                            <i class="material-icons">close</i>
                                        </a>
                                    </div>
                                </div>
                            </li>
                        </ul>

                    </div>

                </div>
            </div>
        </div>

        <div class="card card-form">
            <div class="row no-gutters">
                <div class="col-lg-4 card-body">
                    <p><strong class="headings-color">Event Details</strong></p>
                    <p class="text-muted">Please provide the necessary details about the event, including its name,
                        description, category, and other relevant information. Ensure all required fields are filled out
                        accurately.</p>
                </div>
                <div class="col-lg-8 card-form__body card-body d-flex align-items-center">
                    <div class="row">
                        <div class="form-group col-12">
                            <label for="name">Event Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group col-12">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                        </div>
                        <div class="form-group col-12">
                            <label for="event_category">Event Category</label>
                            <select class="form-control" id="event_category" name="event_category" required>
                                <option value="">Select a category</option>
                                <optgroup label="Work">
                                    <option value="conference">Conference</option>
                                    <option value="workshop">Workshop</option>
                                    <option value="seminar">Seminar</option>
                                    <option value="networking">Networking</option>
                                    <option value="webinar">Webinar</option>
                                </optgroup>
                                <optgroup label="School">
                                    <option value="lecture">Lecture</option>
                                    <option value="exam">Exam</option>
                                    <option value="study_group">Study Group</option>
                                    <option value="graduation">Graduation</option>
                                    <option value="orientation">Orientation</option>
                                </optgroup>
                                <optgroup label="Social">
                                    <option value="party">Party</option>
                                    <option value="festival">Festival</option>
                                    <option value="meetup">Meetup</option>
                                    <option value="charity">Charity Event</option>
                                    <option value="sports">Sports Event</option>
                                </optgroup>
                                <optgroup label="Other">
                                    <option value="competition">Competition</option>
                                    <option value="exhibition">Exhibition</option>
                                    <option value="training">Training</option>
                                    <option value="retreat">Retreat</option>
                                    <option value="custom">Custom Event</option>
                                </optgroup>
                                <!-- Add more categories as needed -->
                            </select>
                        </div>
                        @php
                            $userRoleId = auth()->user()->role ?? null;
                        @endphp

                        @if ($userRoleId === 1)
                            <div class="form-group col-12">
                                <label for="is_important">Is Important?</label>
                                <select class="form-control" id="is_important" name="is_important" required>
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>

                            <div class="form-group col-12">
                                <label for="point">Point (Admin Only)</label>
                                <input type="number" class="form-control" id="point" name="point" min="0">
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>


        <div class="card card-form">
            <div class="row no-gutters">
                <div class="col-lg-4 card-body">
                    <p><strong class="headings-color">Event Schedule and Capacity</strong></p>
                    <p class="text-muted">Provide the planned date, time, maximum number of participants, and the
                        location for the event. Ensure these details are accurate to help attendees plan accordingly.
                    </p>
                </div>
                <div class="col-lg-8 card-form__body card-body d-flex align-items-center">
                    <div class="row">
                        <div class="form-group col-12">
                            <label for="planned_date">Planned Date</label>
                            <input type="date" class="form-control" id="planned_date" name="planned_date" required>
                        </div>
                        <div class="form-group col-12">
                            <label for="planned_time">Planned Time</label>
                            <input type="time" class="form-control" id="planned_time" name="planned_time" required>
                        </div>
                        <div class="form-group col-12">
                            <label for="max_participants">Max Participants</label>
                            <input type="number" class="form-control" id="max_participants" name="max_participants" min="1">
                        </div>
                        <div class="form-group col-12">
                            <label for="location">Location Link (Any maps location link)</label>
                            <input type="text" class="form-control" id="location" name="location">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-form">
            <div class="row no-gutters">
                <div class="col-lg-4 card-body">
                    <p><strong class="headings-color">Participation Fee</strong></p>
                    <p class="text-muted">Specify the fee required for participation in the event. If the event is free,
                        leave this field as 0.</p>
                </div>
                <div class="col-lg-8 card-form__body card-body d-flex align-items-center">
                    <div class="row w-100">
                        <div class="form-group col-12">
                            <label for="participation_fee">Participation Fee</label>
                            <input type="text" class="form-control" id="participation_fee" name="participation_fee"
                                placeholder="0.00" data-mask="#0.00" data-mask-reverse="true" autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <button type="submit" class="btn btn-success btn-lg btn-block">Create Event</button>
    </form>
@endsection