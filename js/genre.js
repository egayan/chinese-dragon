document.addEventListener('DOMContentLoaded', function () {
    const tabLabels = document.querySelectorAll('.tab-label');
    const tabBodies = document.querySelectorAll('.body');

    tabLabels.forEach(label => {
        label.addEventListener('click', function () {
            const index = this.getAttribute('data-index');
            tabBodies.forEach(body => body.style.display = 'none');
            document.querySelector('.body' + index).style.display = 'block';
        });
    });

    const containers = document.querySelectorAll('.Container');
    containers.forEach(container => {
        const boxContainer = container.querySelector('.Box-Container');
        const leftArrow = container.querySelector('.Arrow.left');
        const rightArrow = container.querySelector('.Arrow.right');
        const scrollAmount = 120; // スクロール量を調整
        const itemsPerPage = 5; // 1ページあたりのアイテム数

        // 初期表示
        let currentPage = 0;

        // スクロール処理
        leftArrow.addEventListener('click', function () {
            currentPage = Math.max(currentPage - 1, 0);
            scroll(boxContainer, currentPage * itemsPerPage * scrollAmount);
        });

        rightArrow.addEventListener('click', function () {
            currentPage = Math.min(currentPage + 1, Math.ceil(boxContainer.children.length / itemsPerPage) - 1);
            scroll(boxContainer, currentPage * itemsPerPage * scrollAmount);
        });

        function scroll(boxContainer, scrollTo) {
            boxContainer.scrollTo({
                left: scrollTo,
                behavior: 'smooth' // スムーズにスクロールする
            });
            updateArrowVisibility();
        }

        function updateArrowVisibility() {
            leftArrow.style.display = currentPage === 0 ? 'none' : 'block';
            rightArrow.style.display = (currentPage + 1) * itemsPerPage >= boxContainer.children.length ? 'none' : 'block';
        }

        updateArrowVisibility();
    });

    tabLabels.forEach(label => {
        label.addEventListener('click', function () {
            const index = this.getAttribute('data-index');
            const bodies = document.querySelectorAll('.tab-body .body');
            bodies.forEach(body => body.style.display = 'none');
            document.querySelector('.body' + index).style.display = 'block';
        });
    });
});
