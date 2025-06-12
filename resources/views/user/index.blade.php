 @extends('user.layout.main')
 @section('title', 'Dashboard');
 @section('body')

     <section class="section dashboard">
         <div class="row">
             <div class="col-lg-12 text-center">
                 <h1>Welcome to</h1>
             </div>
         </div>
         <div class="row">
             <div class="col-lg-12 text-center p-4">
                 <img alt="logo" src="{{ asset('admin/images/logo2.png') }}" width="300" height="38">
             </div>
         </div>
         <div class="row pt-2">
             <div class="col-lg-12 text-center">
                 <p><b>Your Gateway To Secure Information For Your</b></p>
             </div>
             <div class="col-lg-12 text-center">
                 <p><b>Partners And Investors</b></p>
             </div>
         </div>
         <div class="row pt-5">
             <div class="col-lg-12 text-center">
                  <img alt="main" src="{{ asset('admin/images/main.jpeg') }}" width="100%" height="100%">
             </div>
            
         </div>
     </section>
 @endsection
