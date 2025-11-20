<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="{{ url('https://cpan.ufms.br') }}">
      <img src="{{ asset('/img/ufms_logo.png') }}" alt="UFMS" class="me-2 ufms_logo" /></a>
    <a class="navbar-brand" href="{{ url('/') }}">Projeto PDFEditor</a>
    
    <x-navbar-toggler />
    
    <div class="collapse navbar-collapse ps-5" id="navbarNav">
      <ul class='navbar-nav'>
        <li class='nav-item'><a class='nav-link' href='#'>Sobre</a></li>
      </ul>
    </div>
  </div>
</nav>