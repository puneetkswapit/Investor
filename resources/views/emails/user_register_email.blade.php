@php
    $mailcontent = App\Models\MailContent::first();
    $data = [
        'email' => 'Puneetss@gmail.com',
        'password' => 'hsfjsfhks',
    ];
    $username = $data['email'];
    $password = $data['password'];
@endphp
{!! $mailcontent->content_1 !!}
<style>



</style>
<div
    style="max-width: 350px; 
            margin: 0 auto; 
            padding: 2px; 
            border-radius: 8px; 
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05); 
            color: #333333;">
    <ul>
        <li><strong>Username:</strong> {{ $username }}</li>
        <li><strong>Password:</strong> {{ $password }}</li>
    </ul>

</div>
<center><a href="#"
        style="display: inline-block; 
          margin-top: 10px; 
          margin-bottom: 20px; 
          padding: 12px 25px; 
          font-size: 16px; 
          color: #ffffff; 
          background-color: #f87603; 
          text-decoration: none; 
          border-radius: 6px;">
        Login to Your Account
    </a>
</center>
{!! $mailcontent->content_2 !!}
