<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Application')</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS (if you have any) -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <button id="scrollToTopBtn" class="scrollToTopBtn">&#8593;</button>

    <main class=" main">
        @include('partials.header')

        @yield('content')
    </main>
    @include('partials.footer')

    <!-- jQuery and Bootstrap JS CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"
        integrity="sha512-7eHRwcbYkK4d9g/6tD/mhkf++eoTHwpNM9woBxtPUBWm67zeAfFC+HrdoE2GanKeocly/VxeLvIqwvCdk7qScg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        // Function to scroll to the top of the page smoothly
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
                // Ensures smooth scrolling
            });
        }

        // Attach event listener to the button
        document.getElementById("scrollToTopBtn").addEventListener("click", scrollToTop);

        // Show/hide the button based on scroll position
        window.addEventListener('scroll', function() {
            const scrollToTopBtn = document.getElementById("scrollToTopBtn");
            if (window.scrollY >
                200) {
                scrollToTopBtn.style.display = 'block';
            } else {
                scrollToTopBtn.style.display = 'none';
            }
        });
    </script>
</body>

</html>
