<header class="container-fluid">
    <div class="row" id="main-header">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link px-2" href="#" id="website-name">Jalani Kumkum</a>
            </li>
        </ul>
        <ul class="user-menu nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('loginPage')}}">login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('registerPage')}}">Register</a>
            </li>
        </ul>
    </div>
</header>
<style>
#website-name 
{
    font-weight: 700;
}
</style>
