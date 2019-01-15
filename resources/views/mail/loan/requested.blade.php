@component('mail::message')
    # Loan Requested

    @component('mail::panel')
        This is the panel content.
    @endcomponent

    Your invoice has been paid!

    @component('mail::table')
        | Laravel       | Table         | Example  |
        | ------------- |:-------------:| --------:|
        | Col 2 is      | Centered      | $10      |
        | Col 3 is      | Right-Aligned | $20      |
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
