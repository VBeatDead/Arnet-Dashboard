@props(['type'])

@if ($type === 'form')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pace/1.2.4/themes/blue/pace-theme-minimal.css" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@^2.2/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@^2.8.2/dist/alpine.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pace/1.2.4/pace.min.js"></script>
    <script>
        document.querySelector('form').addEventListener('submit', function() {
            Pace.restart();
        });
    </script>
@endif

@if ($type === 'load')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pace/1.2.4/themes/blue/pace-theme-minimal.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pace/1.2.4/pace.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Pace.restart();
        });
    </script>
@endif
