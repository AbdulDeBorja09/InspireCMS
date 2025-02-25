<!--FOOTER-->
<footer class="footer">
    <div class="container">
        <div class="row text-md-start text-center footer-box">
            <!-- Logo and Social Media -->
            <div class="col-md-4 mb-4 footer-images">
                @if ($footerLogo)
                <img src="{{ url($footerLogo->value) }}" class="img-fluid" alt="Logo" width="180" />
                @else

                <img src=" {{url('/images/logo/inspire-logo.png')}}" alt="Inspire Sports Academy" width="180" />
                @endif
                <!-- Replace with actual logo -->
                <div class="social-icons mt-3">
                    @if ($facebook)
                    <a href="{{$facebook->value}}" target="_blank">
                        <i class="bi bi-facebook"></i>
                    </a>
                    @endif
                    @if ($instagram)
                    <a href="{{$instagram->value}}" target="_blank">
                        <i class="bi bi-instagram"></i>
                    </a>
                    @endif
                    @if ($tiktok)
                    <a href="{{$tiktok->value}}" target="_blank">
                        <i class="bi bi-tiktok"></i>
                    </a>
                    @endif
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-md-4 mb-4 quick-links">
                <h5 class="fw-bold">Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li><a href="{{url('/Facilities')}}">Facilities</a></li>
                    <li><a href="{{url('/Academies')}}">Academies</a></li>
                    <li><a href="{{url('/Articles')}}">Articles</a></li>
                    <li><a href="{{url('/Faqs')}}">FAQ</a></li>
                    <li><a href="{{url('/About')}}">About</a></li>
                </ul>
            </div>

            <!-- Contact and Location -->
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold">Contact</h5>
                @foreach ($footerContacts as $contacts)
                <p>{{$contacts->value}}</p>
                @endforeach
                <h5 class="fw-bold">Location</h5>
                @foreach ($footerLocations as $location)
                <p>{{$location->value}}</p>
                @endforeach
            </div>
        </div>

        <div class="divider"></div>
        <div class="text-center mt-3">
            <p>
                © 2025,
                <a href="#image">Inspire Sports Academy</a>
            </p>
        </div>
    </div>
</footer>
<!-- END OF FOOTER -->