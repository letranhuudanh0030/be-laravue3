@component('mail::message')
# Contact Us Mail Feedback

<p>Name: {{ $data['name'] }}</p>
<p>Email: {{ $data['email'] }}</p>
<p>Phone: {{ $data['phone'] }}</p>
<p>Message: {{ $data['message'] }}</p>

@component('mail::button', ['url' => ''])
    Button
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
