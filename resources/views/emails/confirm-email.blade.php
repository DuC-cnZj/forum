@component('mail::message')
# 最后一步

验证你的邮箱。

@component('mail::button', ['url' => url('/register/confirm?token=' . $user->confirmation_token)])
confirm email
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
