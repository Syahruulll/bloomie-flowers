const menuOptions = {
    bouquet: ['flower bouquet', 'money bouquet', 'snack bouquet', 'doll bouquet'],
    cake: ['money cake', 'snack cake'],
    rustic: ['papan bunga rustic', 'hantaran rustic'],
    mahar: ['mahar'],
    hampers: ['hampers'],
    designundangan: ['undangan'],
    flowertable: ['flower table'],
};

document.addEventListener('DOMContentLoaded', () => {
    if ('IntersectionObserver' in window && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        const revealObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            });
        }, { threshold: 0.12 });

        document.body.classList.add('motion-enabled');
        document.querySelectorAll('[data-reveal]').forEach((element) => revealObserver.observe(element));
    }

    const menuToggle = document.querySelector('[data-menu-toggle]');
    const siteNavigation = document.querySelector('[data-site-navigation]');

    if (menuToggle && siteNavigation) {
        menuToggle.addEventListener('click', () => {
            const isOpen = menuToggle.getAttribute('aria-expanded') === 'true';
            menuToggle.setAttribute('aria-expanded', String(!isOpen));
            siteNavigation.classList.toggle('is-open', !isOpen);
        });

        siteNavigation.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', () => {
                menuToggle.setAttribute('aria-expanded', 'false');
                siteNavigation.classList.remove('is-open');
            });
        });
    }

    const categoryFilters = document.querySelector('[data-category-filters]');
    const categoryFilterButtons = categoryFilters?.querySelectorAll('[data-category-filter]') ?? [];
    const catalogueSections = [...document.querySelectorAll('[data-section-category]')];
    const filterStatus = document.querySelector('[data-filter-status]');

    if (categoryFilters && categoryFilterButtons.length && catalogueSections.length) {
        const applyCategoryFilter = (selectedCategory) => {
            let visibleProductCount = 0;

            catalogueSections.forEach((section) => {
                const isVisible = selectedCategory === 'all' || section.dataset.sectionCategory === selectedCategory;
                section.hidden = !isVisible;

                if (isVisible) {
                    visibleProductCount += section.querySelectorAll('.product-specimen').length;
                }
            });

            categoryFilterButtons.forEach((button) => {
                button.setAttribute('aria-pressed', String(button.dataset.categoryFilter === selectedCategory));
            });

            if (filterStatus) {
                const selectedButton = [...categoryFilterButtons].find((button) => button.dataset.categoryFilter === selectedCategory);
                const categoryLabel = selectedButton?.textContent.trim();
                const productLabel = visibleProductCount === 1 ? 'product' : 'products';
                filterStatus.textContent = selectedCategory === 'all'
                    ? `Showing all ${visibleProductCount} ${productLabel}.`
                    : `Showing ${visibleProductCount} ${productLabel} in ${categoryLabel}.`;
            }
        };

        categoryFilterButtons.forEach((button) => {
            button.addEventListener('click', () => applyCategoryFilter(button.dataset.categoryFilter));
        });

        categoryFilters.hidden = false;
        applyCategoryFilter('all');
    }

    const categorySelect = document.querySelector('[data-category-select]');
    const menuSelect = document.querySelector('[data-menu-select]');

    if (categorySelect && menuSelect) {
        const form = categorySelect.closest('[data-product-form]');

        const populateMenu = (category, selected = '') => {
            const options = menuOptions[category] || [];
            menuSelect.replaceChildren(new Option(options.length ? 'Choose an item' : 'Choose a category first', ''));

            options.forEach((menu) => {
                const option = new Option(menu.replace(/\b\w/g, (letter) => letter.toUpperCase()), menu);
                option.selected = menu === selected;
                menuSelect.add(option);
            });
        };

        populateMenu(form?.dataset.currentCategory || categorySelect.value, form?.dataset.currentMenu || '');
        categorySelect.addEventListener('change', () => populateMenu(categorySelect.value));
    }

    const photoInput = document.querySelector('[data-photo-input]');
    const photoPreview = document.querySelector('#image-preview');
    const photoPlaceholder = document.querySelector('[data-upload-placeholder]');

    if (photoInput && photoPreview) {
        photoInput.addEventListener('change', () => {
            const file = photoInput.files?.[0];
            if (!file) return;

            photoPreview.src = URL.createObjectURL(file);
            photoPreview.classList.remove('is-hidden');
            if (photoPlaceholder) photoPlaceholder.hidden = true;
        });
    }
});
