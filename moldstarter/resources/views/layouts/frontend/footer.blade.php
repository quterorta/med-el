<footer class="footer gb-3">
    <div class="footer-links-container">
        <a class="footer-social-link" href=""><i class="fa-brands fa-facebook"></i></a>
        <a class="footer-social-link" href=""><i class="fa-brands fa-viber"></i></a>
        <a class="footer-social-link" href=""><i class="fa-brands fa-telegram"></i></a>
        <ul>
            <li><a href="tel:+380993080701">+380993080701</a></li>
            <li><a href="tel:+380976690368">+380976690368</a></li>
            <li><a href="tel:+380916216271">+380916216271</a></li>
            <li><a href="https://goo.gl/maps/fXthmWPFT3SU7BdE8" target="_blank"><i class="fa-solid fa-location-dot"></i> Chișinău, Moldova</a></li>
        </ul>
    </div>
    <div class="footer-form-container">
        <p class="footer-form-container-header">Apel înapoi</p>
        <form id="footerForm" action="{{ route('footer-contact-form') }}">
            <div>
                <input type="text" class="footer-form-input" required placeholder="Nume" id="footerFormName" name="name">
            </div>
            <div>
                <input type="tel" class="footer-form-input" required placeholder="Telefon" id="footerFormPhone" name="phone">
            </div>
            <div>
                <button type="button" id="footerFormButton" class="footer-form-button">Trimite</button>
            </div>
        </form>
    </div>
    <div class="footer-logo-container">
        <a href="{{route('home')}}"><img src="/img/assets/logo.png" alt=""></a>
    </div>
</footer>
