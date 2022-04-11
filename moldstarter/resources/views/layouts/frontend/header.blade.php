<header class="header-pc">
    <div class="header-pc-top-section">
        <div class="header-pc-top-section-logo-container">
            <a href="{{ route('home') }}"><img src="/img/assets/logo.png" alt=""></a>
        </div>
        <div class="header-pc-top-section-search-container">
            <form action="{{ route('search') }}" method="GET">
                <input type="text" name="search" id="search" required class="header-search-form-input" placeholder="Căutare">
                <button type="submit" class="header-search-form-button"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
        </div>
        <div class="header-pc-top-section-links-container">
            <div class="header-pc-top-section-wishlist-container">
                <a href="{{ route('wishlist') }}" title="Lista ta de dorințe" class="wishlistBtn"><i class="fa-solid fa-heart"></i></a>
            </div>
            <div class="header-pc-top-section-phone-container">
                <a href="tel:+380916216271" title="Sună-ne"><i class="fa-solid fa-phone"></i></a>
            </div>
            <div class="header-pc-top-section-lang-container">
                <a href="" title="Alegeți limba"><i class="fa-solid fa-language"></i></a>
            </div>
        </div>
    </div>
    <div class="header-pc-bottom-section">
        <ul>
            <li><a href="{{ route('home') }}">Acasă</a></li>
            <li><a href="{{ route('about-us') }}">Despre noi</a></li>
            <li><a href="{{ route('all-products') }}">Produse MED-EL</a></li>
            <li>
                <div class="categories-dropdown">
                    <span>Categorii</span>
                    <div class="dropdown-content">
                        @foreach($categoriesForMenu as $category)
                            <a class="dropdown-link" href="{{ route('category-detail', $category->slug) }}">{{ $category->title }}</a>
                        @endforeach
                    </div>
                </div>
            </li>
            <li><a href="{{ route('contacts') }}">Contacte</a></li>
        </ul>
    </div>
</header>

<header class="header-mobile">
    <div class="header-mobile-logo-container">
        <a href="{{ route('home') }}">
            <img src="/img/assets/logo.png" alt="">
        </a>
    </div>
    <div class="header-mobile-menu-container">
        <button class="header-mobile-menu-button" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>
</header>


<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Meniul</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="offcanvas-inline-links">
            <a href="{{ route('wishlist') }}" title="Lista ta de dorințe" class="wishlistBtn"><i class="fa-solid fa-heart"></i></a>
            <a href="tel:+380916216271" title="Sună-ne"><i class="fa-solid fa-phone"></i></a>
            <a href="" title="Alegeți limba"><i class="fa-solid fa-language"></i></a>
        </div>
        <div class="offcanvas-mobile-search">
            <form action="{{ route('search') }}" method="GET">
                <input type="text" name="search" id="search" required class="mobile-header-search-form-input" placeholder="Căutare">
                <button type="submit" class="mobile-header-search-form-button"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
        </div>
        <p><a href="{{ route('home') }}">Acasă</a></p>
        <p><a href="{{ route('about-us') }}">Despre noi</a></p>
        <p><a href="{{ route('all-products') }}">Produse MED-EL</a></p>
        <div class="dropdown mt-3">
            <button class="offcanvas-dropdown-button" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown">
                Categorii
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                @foreach($categoriesForMenu as $category)
                    <li><a class="dropdown-item" href="{{ route('category-detail', $category->slug) }}">{{ $category->title }}</a></li>
                @endforeach
            </ul>
        </div>
        <p><a href="{{ route('contacts') }}">Contacte</a></p>
    </div>
</div>


<script>
    $(document).ready(function () {
        $('.wishlistBtn').click(function (event) {
            event.preventDefault();
            $.ajax({
                url: "{{ route('set-wishlist') }}",
                type: "POST",
                data: {
                    'productIds': localStorage.getItem('favorite-products'),
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
                },
                success: (data) => {
                    console.log(data);
                },
                error: (data) => {
                    console.log('error');
                },
                dataType: "json"
            });
            document.location = $(this).attr('href');
        });
    });
</script>
