@component('mail::message')
@if ($mail_data['created'] == 1)
Hello , task has been created by {{ $mail_data['creator'] }}. The task details has been given below :
@else
Hello, task has been updated by {{ $mail_data['creator'] }} from {{ $mail_data['from'] }} to {{ $mail_data['to'] }}. The task details has been given below :  
@endif
<br>
<b>Name </b> : {{ $mail_data['task']['name'] }} <br>
<b>Deadline </b> : {{ $mail_data['task']['deadline'] }} <br>
<b>Priority </b> : {{ $mail_data['task']['priority'] }} <br>
@if ($mail_data['created'] != 1)
<b>Changed From </b> : {{ $mail_data['from'] }} <br>
<b>Changed To </b> : {{ $mail_data['to'] }} <br>
@endif

Thanks,<br>
{{ config('app.name') }}
@endcomponent