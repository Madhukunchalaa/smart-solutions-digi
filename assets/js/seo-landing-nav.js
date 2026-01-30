document.addEventListener('DOMContentLoaded', function() {
    const mobileToggle = document.querySelector('.mobile-toggle');
    const navLinks = document.querySelector('.floating-nav .nav-links');
    
    // Create Backdrop
    const backdrop = document.createElement('div');
    backdrop.className = 'mobile-menu-backdrop';
    document.body.appendChild(backdrop);
    
    // Add Close Button to Menu
    if (navLinks) {
        // Only add if not exists
        if (!navLinks.querySelector('.mobile-close-btn')) {
            const closeBtn = document.createElement('div');
            closeBtn.className = 'mobile-close-btn';
            closeBtn.innerHTML = '<i class="fa fa-times"></i>';
            navLinks.prepend(closeBtn);
            
            closeBtn.addEventListener('click', closeMenu);
        }
    }

    function openMenu() {
        navLinks.classList.add('active');
        backdrop.classList.add('active');
        document.body.style.overflow = 'hidden'; // Lock scroll
    }
    
    function closeMenu() {
        navLinks.classList.remove('active');
        backdrop.classList.remove('active');
        document.body.style.overflow = ''; // Unlock scroll
        
         // Reset Toggle Icon
         const icon = mobileToggle.querySelector('i');
         if (icon) {
             icon.classList.remove('fa-times');
             icon.classList.add('fa-bars');
         }
    }

    if (mobileToggle && navLinks) {
        mobileToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            if (navLinks.classList.contains('active')) {
                closeMenu();
            } else {
                openMenu();
            }
        });

        // Close menu when clicking backdrop
        backdrop.addEventListener('click', closeMenu);
        
        // Close menu when clicking a link
        const links = navLinks.querySelectorAll('a');
        links.forEach(link => {
            link.addEventListener('click', closeMenu);
        });
    }
});
