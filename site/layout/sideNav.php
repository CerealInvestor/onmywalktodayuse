<div class="content right">
    <ul class="sideNav">
        <li><a href="?page=home"<?php if($page == 'home' || !$page) : echo 'class="selected"'; endif; ?>>Home</a></li>
        <li><a href="?page=blog"<?php if($page == 'blog') : echo 'class="selected"'; endif; ?>>Blog</a></li>
        <li><a href="?page=about"<?php if($page == 'about') : echo 'class="selected"'; endif; ?>>About</a></li>
        <li><a href="?page=faq"<?php if($page == 'faq') : echo 'class="selected"'; endif; ?>>FAQ</a></li>
        <li><a href="?page=contact"<?php if($page == 'contact') : echo 'class="selected"'; endif; ?>>Contact</a></li>
    </ul>
    <ul class="sideNav">
        <li><h2>Latest Blog Posts</h2></li>
        <li><a href="">Onmywalk</a></li>
        <li><a href="">Onmywalk</a></li>
        <li><a href="">Onmywalk</a></li>
    </ul>
</div>