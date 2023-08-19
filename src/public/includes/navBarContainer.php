<div id="navBarContainer">
	<nav class="navBar">
        <span role="link" tabindex="0" class="logo">
            <img src="assets/images/icons/logo.png" alt="">
        </span>

		<div class="group">
			<div class="navItem">
                <span role="link" tabindex="0" class="navItemLink search">Search
                    <img src="assets/images/icons/search.png" alt="Search" class="icon">
                </span>
			</div>
		</div>
		<div class="group">
			<div class="navItem">
				<span role="link" tabindex="0" class="navItemLink browse">Browse</span>
			</div>
			<div class="navItem">
				<span role="link" tabindex="0" class="navItemLink yourMusic">Your Music</span>
			</div>
			<div class="navItem">
				<span role="link" tabindex="0" class="navItemLink profile"><?php echo $userLoggedIn->getFirstAndLastName(); ?> </span>
			</div>
			<div class="navItem">
				<span role="link" tabindex="0" class="navItemLink usageNotice">Disclaimer</span>
			</div>
		</div>
	</nav>
</div>