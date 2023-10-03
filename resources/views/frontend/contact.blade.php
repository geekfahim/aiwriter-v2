@extends('frontend/layout')
@section('content')
    <!-- ========== MAIN CONTENT ========== -->
    <section id="contact-center-form" class="pt-50 pb-50 pt-md-150 pb-md-100 light">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-5 mr-auto" style="">
                    <h3 class=""><strong>Contact us</strong></h3>
                    <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 0 100 20" width="100"
                         class="mb-30 svg-secondary">
                        <path d="m0 9h100v2h-100z" fill-rule="evenodd"></path>
                    </svg>
                    <p class="mb-30" style="">In our work we try to use only the most modern, convenient and interesting
                        AI solutions.</p>
                    <div class="inline-group mb-50">


                    </div>
                </div>
                <div class="col-md-6">
                    <form action="request.php" class="contact_form form-vertical mb-30"
                          id="contact-center-form-form" novalidate="novalidate" style="">
                        <div class="form-group text-field-group"><input type="text" class="form-control"
                                                                        placeholder="Full Name" name="NAME" size="10">
                        </div>
                        <div class="form-group email-field-group"><input type="email" class="form-control"
                                                                         placeholder="Email Address" name="EMAIL"
                                                                         size="10"></div>
                        <div class="form-group textarea-group"><textarea class="form-control" placeholder="Description"
                                                                         rows="5" name="TEXT"></textarea></div>
                        <button type="submit" data-loading-text="•••" data-complete-text="Completed!"
                                data-reset-text="Try again later..." class="btn btn-dark btn-block" style="">Send
                            message
                        </button>
                    </form>
                    <p class="small text-secondary">You are very important to us, all information received will always
                        remain confidential.</p>
                </div>
            </div>
        </div>
        <div class="bg-wrap">
            <div class="bg"></div>
        </div>
    </section>
    <!-- ========== END MAIN CONTENT ========== -->
@endsection
