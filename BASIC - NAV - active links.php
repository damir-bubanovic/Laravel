<?php 
/*

!! BASIC - NAVIGATION - ACTIVE LINKS !!

> apply bootstrap class="active to active links"
> use terinary operator

> Request::is('/') - is we are on this page (in our case '/' root page)

*/
<li class="{{ Request::is('/') ? 'active' : '' }}"><a href="/myLavPro/public">Home</a></li>
<li class="{{ Request::is('about') ? 'active' : '' }}"><a href="/myLavPro/public/about">About</a></li>
<li class="{{ Request::is('contact') ? 'active' : '' }}"><a href="/myLavPro/public/contact">Contact</a></li>
?>