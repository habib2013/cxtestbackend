@component('mail::message')
# Welcome onboard

Hi {{ $userwallet->first_name }} , 
Welcome to a world of more convenience.
With the Capital X wallet, you can enjoy unlimited free bank transfers, high interest on savings and hassle free bills payments.
You can upgrade your account by ordering for your card or opting for a Premium plan
Need help? Kindly reach our support team via support@capitalx.cards or 0043482725.
Once again, welcome onboard!
Your friends at Capital X



Thanks,<br>
{{ config('app.name') }}
@endcomponent
