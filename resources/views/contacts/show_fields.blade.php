<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    {{ $contact->name }}
</div>

<div class="form-group">
    {!! Form::label('updated_at', 'Qontact ID:') !!}
    {{ $contact->qontact_id }}
</div>

<div class="form-group">
    {!! Form::label('updated_at', 'Simma ID:') !!}
    {{ $contact->simma_id }}
</div>

<!-- Sponsor Id Field -->
<div class="form-group">
    {!! Form::label('sponsor_id', 'Partner Id:') !!}
    {{ $contact->partner_id }}
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    {{ $contact->date_added }}
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    {{ $contact->update_at }}
</div>

<div class="form-group">
    {!! Form::label('updated_at', 'Posted to Qontact:') !!}
    {{ $contact->posted_to_qontact_date }}
</div>

<!-- Status Field -->
<div class="form-group">
    {!! Form::label('status', 'Status:') !!}
    {{ $contact->status }}
</div>


<!-- Contact Email Field -->
<div class="form-group">
    {!! Form::label('contact_email', 'Contact Email:') !!}
    {{ $contact->contact_email }}
</div>

<!-- Phone Number Field -->
<div class="form-group">
    {!! Form::label('phone_number', 'Phone Number:') !!}
    {{ $contact->phone_number }}
</div>


<!-- Date Of Birth Field -->
<div class="form-group">
    {!! Form::label('date_of_birth', 'Date Of Birth:') !!}
    {{ $contact->date_of_birth }}
</div>

<!-- Source Field -->
<div class="form-group">
    {!! Form::label('source', 'Source:') !!}
    {{ $contact->source }}
</div>

<!-- Name See Field -->
<div class="form-group">
    {!! Form::label('name_see', 'Name See:') !!}
    {{ $contact->name_see }}
</div>

<!-- Motivation Code Field -->
<div class="form-group">
    {!! Form::label('motivation_code', 'Motivation Code:') !!}
    {{ $contact->motivation_code }}
</div>

<!-- Join Date Field -->
<div class="form-group">
    {!! Form::label('join_date', 'Join Date:') !!}
    {{ $contact->join_date }}
</div>

<!-- Title Field -->
<div class="form-group">
    {!! Form::label('title', 'Title:') !!}
    {{ $contact->title }}
</div>




<!-- Email Sponsor Field -->
<div class="form-group">
    {!! Form::label('email_sponsor', 'Email Sponsor:') !!}
    {{ $contact->email_sponsor }}
</div>

<!-- Need Tp Post Field -->
<!-- <div class="form-group">
    {!! Form::label('need_tp_post', 'Need Tp Post:') !!}
    {{ $contact->need_tp_post }}
</div> -->



<!-- Sp Field -->
<div class="form-group">
    {!! Form::label('sp', 'Sp:') !!}
    {{ $contact->sp }}
</div>


<!-- En Field -->
<div class="form-group">
    {!! Form::label('en', 'En:') !!}
    {{ $contact->en }}
</div>

<!-- Pl Field -->
<div class="form-group">
    {!! Form::label('pl', 'Pl:') !!}
    {{ $contact->pl }}
</div>

<!-- Dr Field -->
<div class="form-group">
    {!! Form::label('dr', 'Dr:') !!}
    {{ $contact->dr }}
</div>


