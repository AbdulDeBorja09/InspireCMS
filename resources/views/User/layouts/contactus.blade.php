<!-- CONTACT US -->
<section id="contact"
    style="background-image: url('{{ asset('/images/contact-bg.png') }}'); background-size: cover; background-position: center; height: 100%;">
    <div class="mb-5 container-fluid">
        <div class="row">
            <div class="col-lg-6 form-container">
                <h1 class="sub-title">Contact Us</h1>
                <form method="POST" action="{{route('contactus')}}">
                    @csrf
                    <div class="input-group">
                        <input type="text" placeholder="First Name" name="fname" required />
                        <input type="text" placeholder="Last Name" name="lname" required />
                    </div>
                    <div class="input-group">
                        <input type="email" placeholder="Your Email" name="email" required />
                        <input type="tel" placeholder="Your Phone" name="phone" required />
                    </div>
                    <div class="message-group">
                        <textarea placeholder="Message" required name="message"></textarea>
                    </div>
                    <button class="submit-btn" type="submit">Submit</button>
                </form>
            </div>

            {{-- <div class="col-lg-6 contact-image" style="background-image: ">
                <img src="{{asset('/images/contact-bg.png')}}" alt="Academy Image" class="img-fluid" />
            </div> --}}
        </div>
    </div>
</section>
<!-- END OF CONTACT US -->